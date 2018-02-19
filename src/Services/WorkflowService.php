<?php

namespace Belt\Core\Services;

use Belt;
use Belt\Core\Workflows\WorkflowInterface;
use Belt\Core\WorkRequest;
use Illuminate\Database\Eloquent\Model;

class WorkflowService
{
//    use Belt\Core\Behaviors\CanEnable;

    /**
     * @var array
     */
    protected static $workflows = [];

    /**
     * @var Model
     */
    private $item;

    /**
     * @var WorkflowInterface
     */
    private $workflow;

    /**
     * @var WorkRequest
     */
    private $workRequest;

    /**
     * @var WorkRequest
     */
    private $qb;

    /**
     * @param string
     */
    public static function registerWorkflow($workflowClass)
    {
        $workflow = new $workflowClass();
        if ($workflow instanceof WorkflowInterface) {
            $accessor = $workflow->getAccessor();
            static::$workflows[$accessor] = $workflowClass;
        }
    }

    /**
     * WorkflowService constructor.
     */
    public function __construct()
    {
        $this->setQB(new WorkRequest());
    }

    /**
     * @param Model|null $item
     */
    public function setItem(Model $item = null)
    {
        $this->item = $item;
    }

    /**
     * @return Model $item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $workRequest
     */
    public function setWorkRequest($workRequest)
    {
        $this->workRequest = $workRequest;
    }

    /**
     * @return mixed
     */
    public function getWorkRequest()
    {
        return $this->workRequest;
    }

    /**
     * @param WorkRequest $qb
     */
    public function setQB(WorkRequest $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @return mixed
     */
    public function getQB()
    {
        return $this->qb;
    }

    /**
     * @param mixed $workflow
     */
    public function setWorkflow($workflow)
    {
        if (is_string($workflow)) {
            if ($workflow = array_get(static::$workflows, $workflow)) {
                $workflow = new $workflow();
            }
        }

        $this->workflow = $workflow;
    }

    /**
     * @return mixed
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param $workflow
     * @param null $item
     * @param array $payload
     */
    public function handle($workflow, $item = null, $payload = [])
    {
        $this->setWorkflow($workflow);

        $this->setItem($item);

        if ($workflow->isApplicable($item)) {
            $this->createWorkRequest($workflow, $item, $workflow->initialPlace(), $payload);
        }
    }

    /**
     * @param $workflow
     * @param null $item
     * @param null $place
     * @param array $payload
     * @return mixed
     */
    public function createWorkRequest($workflow, $item = null, $place = null, $payload = [])
    {
        WorkRequest::unguard();

        $place = $place ?: $workflow->initialPlace();

        $workRequest = $this->getQB()->create([
            'workable_id' => $item->id,
            'workable_type' => $item->getMorphClass(),
            'workflow_class' => get_class($workflow),
            'place' => $place,
            'payload' => $payload,
        ]);

        $this->setWorkRequest($workRequest);

        return $workRequest;
    }

    /**
     * @param $place
     * @return bool
     */
    public function can($place)
    {
        return $this->helper()->can($this->setWorkRequest(), $place);
    }

    /**
     * @param $key
     * @param array $payload
     */
    public function apply($key, $payload = [])
    {
        if ($this->can($key)) {
            $workRequest = $this->setWorkRequest();
            $this->helper()->apply($workRequest, $key);
            $method = camel_case('apply_' . $key);
            if (method_exists($this, $method)) {
                $this->$method($payload);
            }
            if (in_array($key, $this->close)) {
                $workRequest->is_open = false;
            }
            $workRequest->save();
        };
    }

    /**
     * @param Helper $helper
     * @return $this
     */
    public function setHelper(Helper $helper)
    {
        $this->helper = $helper;

        return $this;
    }

    /**
     * @return Helper
     */
    public function helper()
    {
        if ($this->helper) {
            return $this->helper;
        }

        // definition
        $builder = new DefinitionBuilder();
        $builder->setInitialPlace($this->initialPlace);
        $builder->addPlaces($this->places);
        foreach ($this->transitions as $name => $config) {
            $builder->addTransition(new Transition($name, $config['from'], $config['to']));
        }
        $definition = $builder->build();

        // marking
        $marking = new SingleStateMarkingStore('place');

        // workflow
        $helper = new Helper($definition, $marking, null, static::getAccessor());

        $this->setHelper($helper);

        return $helper;
    }

    /**
     * @return array
     */
    public function availableTransitions()
    {
        $available = [];
        foreach ($this->transitions() as $name => $params) {
            if ($this->can($name)) {
                $available[] = $name;
            }
        };

        return $available;
    }

}