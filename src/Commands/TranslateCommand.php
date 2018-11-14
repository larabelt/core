<?php

namespace Belt\Core\Commands;

use Belt, Morph, Translate;
use Illuminate\Console\Command;

/**
 * Class TranslateCommand
 * @package App\Commands
 */
class TranslateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:translate {--limit=1} {--type=} {--id=} {--locale=} {--attribute=} {--debug} {--queue} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        foreach ($this->types() as $type) {

            $limit = $this->option('limit');

            $qb = Morph::type2QB($type);

            if ($ids = $this->ids()) {
                $limit = count($ids);
                $qb->whereIn('id', $ids);
            }

            $count = 1;
            foreach ($qb->get() as $item) {
                foreach ((array) $item->config('translatable') as $attribute) {
                    $this->translate($item, $attribute);
                }
                foreach ((array) $item->config('params') as $key => $config) {
                    if (array_get($config, 'translatable')) {
                        if ($param = $item->params->where('key', $key)->first()) {
                            $this->translate($param, 'value');
                        };
                    }
                }
                if ($count++ >= $limit) {
                    break;
                }
            }
        }

    }

    public function translate($item, $attribute)
    {
        if ($attributes = $this->attributes()) {
            if (!in_array($attribute, $attributes)) {
                return;
            }
        }

        $sourceValue = $item->getOriginal($attribute);

        if (!$sourceValue) {
            return;
        }

        foreach ($this->locales() as $locale) {

            $existingTranslation = $item->translations
                ->where('translatable_column', $attribute)
                ->where('locale', $locale)
                ->first();
            //$this->info($existingTranslation->value);

            if (!$this->option('force') && $existingTranslation && $existingTranslation->value) {
                continue;
            }

            if ($this->option('queue')) {
                dispatch(new Belt\Core\Jobs\TranslateValue($item, $attribute, $sourceValue, $locale));
            } else {
                if ($newValue = Translate::translate($sourceValue, $locale)) {
                    $item->saveTranslation($attribute, $newValue, $locale);
                    if ($this->option('debug')) {
                        $this->info("($locale) $attribute \r\n from: $sourceValue \r\n to: $newValue");
                        //$this->info("($locale) $attribute to: \r\n $newValue");
                        //$this->info("($locale) $attribute: $sourceValue --> $newValue");
                    }
                }
            }
        }

    }

    public function attributes()
    {
        return array_filter(explode(',', $this->option('attribute', '')));
    }


    public function ids()
    {
        return array_filter(explode(',', $this->option('id', '')));
    }

    public function locales()
    {
        $locales = array_filter(explode(',', $this->option('locale', '')));
        $locales = $locales ?: array_pluck(Translate::getAlternateLocales(), 'code');

        return $locales;
    }

    public function types()
    {
        return array_filter(explode(',', $this->option('type', '')));
    }

}