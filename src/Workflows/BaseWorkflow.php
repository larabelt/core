<?php

namespace Belt\Core\Workflows;

use Belt, Illuminate;
use Belt\Core\WorkRequest;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow as Helper;
use Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore;

/**
 * Class BaseWorkflow
 * @package Belt\Core\Workflows
 */
class BaseWorkflow implements Belt\Core\Workflows\WorkflowInterface
{

    /**
     * @var array
     */
    protected $places = [];

    /**
     * @var array
     */
    protected $initialPlace = 'start';

    /**
     * @var array
     */
    protected $transitions = [];

    /**
     * @var array
     */
    protected $close = [];

    /**
     * @var Model
     */
    private $item;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var WorkRequest
     */
    private $workRequest;

    /**
     * @var WorkRequest
     */
    private $workRequests;

    /**
     * BaseWorkflow constructor.
     * @param Model $item
     */
    public function __construct(Model $item = null)
    {
        if ($item) {
            $this->setItem($item);
        }
        $this->setWorkRequests(new WorkRequest());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getAccessor()
    {
        return static::NAME;
    }

    private function method($event)
    {
        if ($event instanceof Belt\Core\Events\ItemCreated) {
            return 'created';
        }

        if ($event instanceof Belt\Core\Events\ItemUpdated) {
            return 'created';
        }

        if ($event instanceof Belt\Core\Events\ItemDeleted) {
            return 'created';
        }
    }

    /**
     * @param Model $item
     * @return $this
     */
    public function setItem(Model $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Model $item
     */
    public function item()
    {
        return $this->item;
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

    /**
     * @param null $key
     * @return array|mixed
     */
    public function transitions($key = null)
    {
        if ($key) {
            return array_get($this->transitions, $key, []);
        }

        return $this->transitions;
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
     * @param WorkRequest $workRequest
     * @return $this
     */
    public function setWorkRequest(WorkRequest $workRequest)
    {
        $this->workRequest = $workRequest;

        return $this;
    }

    /**
     * @param WorkRequest $workRequests
     * @return $this
     */
    public function setWorkRequests(WorkRequest $workRequests)
    {
        $this->workRequests = $workRequests;

        return $this;
    }

    /**
     * @param null $place
     * @param array $payload
     * @return mixed
     */
    public function workRequest($place = null, $payload = [])
    {
        WorkRequest::unguard();

        $workRequest = $this->workRequests->firstOrCreate([
            'workable_id' => $this->item->id,
            'workable_type' => $this->item->getMorphClass(),
            'workflow_class' => get_class($this),
        ]);

        if (!$workRequest->place) {
            $workRequest->place = $this->initialPlace;
        }

        if ($place) {
            $workRequest->place = $place;
        }

        if ($payload) {
            $workRequest->payload = $payload;
        }

        $workRequest->save();

        $this->setWorkRequest($workRequest);

        return $workRequest;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => static::getAccessor(),
            'initialPlace' => $this->initialPlace,
            'places' => $this->places,
            'transitions' => $this->transitions,

            // place holders
            'item_label' => sprintf('%s:%s', $this->workRequest()->workable_type, $this->workRequest()->workable_id),
            'item_url' => '',
        ];
    }

    /**
     * @param array $payload
     * @return mixed
     */
    public function create($payload = [])
    {
        $workRequest = $this->workRequest($this->initialPlace, $payload);

        return $workRequest;
    }

    /**
     * @param $place
     * @return bool
     */
    public function can($place)
    {
        return $this->helper()->can($this->workRequest(), $place);
    }

    /**
     * @param $key
     * @param array $payload
     */
    public function apply($key, $payload = [])
    {
        if ($this->can($key)) {
            $workRequest = $this->workRequest();
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

}