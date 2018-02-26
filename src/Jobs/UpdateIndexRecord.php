<?php

namespace Belt\Core\Jobs;

use Belt, Illuminate;
use Belt\Core\Services\IndexService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UpdateIndexRecord
 * @package Belt\Core\Listeners
 */
class UpdateIndexRecord implements
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
     * @var IndexService
     */
    public $service;

    /**
     * @return IndexService
     */
    public function service()
    {
        return $this->service ?: new IndexService();
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        if ($item = $this->item()) {
            $this->service()->setItem($item)->upsert();
        }
    }

}