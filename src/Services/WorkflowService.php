<?php

namespace Belt\Core\Services;

use Belt;
use Belt\Core\Workflows\WorkflowInterface;
use Belt\Core\WorkRequest;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow as Helper;
use Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore;

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
    private $workable;

    /**
     * @var WorkRequest
     */
    private $qb;

    /**
     * @param string
     */
    public static function registerWorkflow($workflowClass)
    {
        static::$workflows[$workflowClass::ACCESSOR] = $workflowClass;
    }

    /**
     * WorkflowService constructor.
     */
    public function __construct()
    {
        $this->setQB(new WorkRequest());
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
     * @param WorkflowInterface $workflow
     * @param Model|null $workable
     * @param array $payload
     */
    public function handle(WorkflowInterface $workflow, Model $workable = null, $payload = [])
    {
        if ($workflow->begin($workable, $payload)) {
            $this->createWorkRequest($workflow, $workable, $workflow->initialPlace(), $payload);
        }
    }

    /**
     * @param WorkflowInterface $workflow
     * @param Model|null $workable
     * @param null $place
     * @param array $payload
     * @return mixed
     */
    public function createWorkRequest(WorkflowInterface $workflow, Model $workable = null, $place = null, $payload = [])
    {
        WorkRequest::unguard();

        $workRequest = $this->getQB()->firstOrCreate([
            'workable_id' => $workable->id,
            'workable_type' => $workable->getMorphClass(),
            'workflow_class' => get_class($workflow),
        ]);

        $workRequest->update([
            'is_open' => true,
            'place' => $place,
            'payload' => $payload,
        ]);

        return $workRequest;
    }

    /**
     * @param WorkRequest $workRequest
     * @param $transition
     * @param array $payload
     * @return WorkRequest
     */
    public function apply(WorkRequest $workRequest, $transition, $payload = [])
    {

        $workflow = $workRequest->getWorkflow();

        $helper = $this->helper($workflow);

        if ($helper->can($workRequest, $transition)) {

            $helper->apply($workRequest, $transition);

            $method = camel_case('apply_' . $transition);
            if (method_exists($workflow, $method)) {
                $workflow->$method($workRequest->workable, $payload);
            }

            if (in_array($transition, $workflow->closers())) {
                $workRequest->is_open = false;
            }

            $workRequest->save();
        };

        return $workRequest;
    }

    /**
     * @param WorkflowInterface $workflow
     * @return Helper
     */
    public function helper(WorkflowInterface $workflow)
    {
        // definition
        $builder = new DefinitionBuilder();
        $builder->setInitialPlace($workflow->initialPlace());
        $builder->addPlaces($workflow->places());
        foreach ($workflow->transitions() as $name => $config) {
            $builder->addTransition(new Transition($name, $config['from'], $config['to']));
        }
        $definition = $builder->build();

        // marking
        $marking = new SingleStateMarkingStore('place');

        // workflow
        $helper = new Helper($definition, $marking, null, $workflow->getAccessor());

        return $helper;
    }

    /**
     * @param WorkflowInterface $workflow
     * @param null $place
     * @return array
     */
    public function availableTransitions(WorkflowInterface $workflow, $place = null)
    {
        $place = $place ?: $workflow->initialPlace();

        $available = [];
        foreach ($workflow->transitions() as $name => $params) {
            if ($place == array_get($params, 'from')) {
                $available[] = $name;
            }
        };

        return $available;
    }

}