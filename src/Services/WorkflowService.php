<?php

namespace Belt\Core\Services;

use Belt, Morph;
use Belt\Core\Workflows\WorkflowInterface;
use Belt\Core\WorkRequest;
use Illuminate\Database\Eloquent\Model;

//use Symfony\Component\Workflow\DefinitionBuilder;
//use Symfony\Component\Workflow\Transition;
//use Symfony\Component\Workflow\Workflow as Helper;
//use Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore;

class WorkflowService
{
    /**
     * @var array
     */
    protected static $workflows = [];

    /**
     * @var Model
     */
    private $workable;

//    /**
//     * @var WorkRequest
//     */
//    private $qb;

    /**
     * @param string
     */
    public static function push($class)
    {
        static::$workflows[$class::KEY] = $class;
    }

    /**
     * @param null $key
     * @return array|mixed
     */
    public static function get($key = null)
    {
        if ($key) {
            return array_get(static::$workflows, $key);
        }

        return static::$workflows;
    }

//    /**
//     * WorkflowService constructor.
//     */
//    public function __construct()
//    {
//        $this->setQB(new WorkRequest());
//    }

//    /**
//     * @param WorkRequest $qb
//     */
//    public function setQB(WorkRequest $qb)
//    {
//        $this->qb = $qb;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getQB()
//    {
//        return $this->qb;
//    }

    /**
     * @param WorkflowInterface $workflow
     * @param Model|null $workable
     * @param array $payload
     */
    public function handle(WorkflowInterface $workflow, Model $workable = null, $user = null, $payload = [])
    {
        $params = [
            'workable' => $workable,
            'user' => $user,
            'payload' => $payload,
        ];

        if ($workflow->shouldStart($params)) {
            $this->createWorkRequest($workflow, $workable, $workflow->initialPlace(), $payload);
            $workflow->start($params);
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

        $qb = Morph::type2QB('work_requests');

        $workRequest = $qb->firstOrCreate([
            'is_open' => true,
            'workable_id' => $workable->id,
            'workable_type' => $workable->getMorphClass(),
            'workflow_key' => $workflow::KEY,
        ]);

        $workRequest->update([
            'place' => $place,
            'payload' => $payload,
        ]);

        return $workRequest;
    }

    public function can(WorkflowInterface $workflow, $place, $key)
    {
        if (!array_get($workflow::transitions(), $key)) {
            return false;
        }

        return $place == array_get($workflow::transitions(), "$key.from");
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

        if ($this->can($workflow, $workRequest->place, $transition)) {

            $workRequest->place = array_get($workflow::transitions(), "$transition.to");

            $method = camel_case('apply_' . $transition);
            if (method_exists($workflow, $method)) {
                //$workflow->$method($workRequest->workable, $payload);
                $workflow->$method([
                    'workRequest' => $workRequest,
                    'workable' => $workRequest->workable,
                    'payload' => $payload,
                ]);
            }

            if (in_array($transition, $workflow->closers())) {
                $workRequest->is_open = false;
            }

            $workRequest->save();
        };

        return $workRequest;
    }

    /**
     * @param WorkRequest $workRequest
     * @param array $payload
     * @return WorkRequest
     */
    public function reset(WorkRequest $workRequest, $payload = [])
    {
        $workflow = $workRequest->getWorkflow();

        $workRequest->is_open = true;
        //$workRequest->place = $workflow::initialPlace();
        $workRequest->place = null;
        $workRequest->save();

        $workflow->start([
            'workable' => $workRequest->workable,
            'payload' => $payload,
        ]);

        return $workRequest;
    }

//    /**
//     * @param WorkflowInterface $workflow
//     * @return Helper
//     */
//    public function helper(WorkflowInterface $workflow)
//    {
//
//        // definition
//        $builder = new DefinitionBuilder();
//        //$builder->setInitialPlace($workflow::initialPlace());
//        $builder->setInitialPlace('review');
//        $builder->addPlaces($workflow->places());
//        foreach ($workflow->transitions() as $name => $config) {
//            $builder->addTransition(new Transition($name, $config['from'], $config['to']));
//        }
//        $definition = $builder->build();
//
//        // marking
//        $marking = new SingleStateMarkingStore('place');
//
//        // workflow
//        $helper = new Helper($definition, $marking, null, $workflow::KEY);
//
//        return $helper;
//    }

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