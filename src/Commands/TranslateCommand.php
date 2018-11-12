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
    protected $signature = 'translate {--limit=1} {--type=} {--id=} {--locale=} {--attribute=} ';

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
        $limit = $this->option('limit');

        foreach ($this->types() as $type) {
            $qb = Morph::type2QB($type);

            if ($ids = $this->ids()) {
                $qb->whereIn('id', $ids);
            }

            $count = 1;
            foreach ($qb->get() as $item) {
                foreach ($item->config('translatable') as $attribute) {
                    $this->translate($item, $attribute);
                }
                foreach ($item->config('params') as $key => $config) {
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

        $originalValue = $item->getOriginal($attribute);

        if ($originalValue) {
            foreach ($this->locales() as $locale) {
                if ($newValue = Translate::translate($originalValue, $locale)) {
                    $item->saveTranslation($attribute, $newValue, $locale);
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