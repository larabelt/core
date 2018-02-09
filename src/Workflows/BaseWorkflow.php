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
        //$this->setItem($item);
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
     * @param Helper $helper
     * @return $this
     */
    public function setHelper(Helper $helper)
    {
        $this->helper = $helper;

        return $this;
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
        $marking = new SingleStateMarkingStore('step');

        // workflow
        $helper = new Helper($definition, $marking, null, static::getAccessor());

        $this->setHelper($helper);

        return $helper;
    }

    public function create($payload = [])
    {
        $workRequest = $this->workRequest($this->initialPlace, $payload);

        return $workRequest;
    }

    public function saved()
    {
        dump(self::getAccessor());
        $this->workRequest('published');
        dump($this->workRequest->toArray());
    }

    public function tmp()
    {
        //$dispatcher = app(Illuminate\Events\Dispatcher::class);
        $workflow = null;
        $workRequest = null;
        dump($workflow->can($workRequest, 'reject'));
        dump($workflow->apply($workRequest, 'publish'));
    }

    public function workRequest($step = null, $payload = [])
    {
        WorkRequest::unguard();

        $workRequest = $this->workRequests->updateOrCreate([
            'workable_id' => $this->item->id,
            'workable_type' => $this->item->getMorphClass(),
            'workflow' => get_class($this),
        ], [
            'step' => $step,
            'payload' => $payload,
        ]);

        $this->setWorkRequest($workRequest);

        return $workRequest;
    }

}