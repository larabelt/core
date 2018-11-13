<?php

namespace Belt\Core\Jobs;

use Belt, Translate;
use Belt\Core\Services\TranslateService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TranslateValue implements
    ShouldQueue,
    Belt\Core\Events\ItemEventInterface
{
    use Belt\Core\Events\ItemEventTrait;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * @var Belt\Core\Behaviors\TranslatableInterface
     */
    public $zitem;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $target_locale;

    /**
     * @var string
     */
    public $source_locale;

    /**
     * @var TranslateService
     */
    public $service;

    /**
     * @return TranslateService
     */
    public function service()
    {
        return $this->service = $this->service ?: new TranslateService();
    }

    /**
     * TranslateValue constructor.
     * @param $text
     * @param $target_locale
     * @param array $source_locale
     */
    public function __construct($item, $attribute, $text, $target_locale, $source_locale = null)
    {
        $this->setItemId($item->id);
        $this->setItemType($item->getMorphClass());

        $this->attribute = $attribute;
        $this->text = $text;
        $this->target_locale = $target_locale;
        $this->source_locale = $source_locale;
    }

    /**
     * Execute the job
     *
     * @throws \Exception
     */
    public function handle()
    {
        if ($newValue = Translate::translate($this->text, $this->target_locale)) {
            $this->item()->saveTranslation($this->attribute, $newValue, $this->target_locale);
        }
    }

}
