<?php

namespace Belt\Core\Jobs;

use Belt, Illuminate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UpdateIndexRecord
 * @package Belt\Core\Listeners
 */
class DeleteIndexRecord implements
    ShouldQueue,
    Belt\Core\Events\ItemEventInterface
{
    use Belt\Core\Events\ItemEventTrait;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Bus\Queueable;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * UpdateIndexRecord constructor.
     */
    public function __construct(Model $item)
    {
        $this->setId($item->id);
        $this->setType($item->getMorphClass());
        $this->service = new Belt\Core\Services\IndexService();
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $this->service->delete($this->getId(), $this->getType());
    }

}