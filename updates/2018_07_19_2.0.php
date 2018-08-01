<?php

use Belt\Core\Services\Update\BaseUpdate;
use Illuminate\Support\Facades\DB;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class BeltUpdateCore20 extends BaseUpdate
{
    public function up()
    {
        // bouncer related...

        # renames
        $this->info(sprintf('2.0 renaming'));
        $this->rename(config_path('belt/templates'), config_path('belt/subtypes'));

        # rename resource paths
        $paths = $this->disk()->files('resources/views', true);
        foreach ($paths as $path) {
            $dir = '';
            foreach (explode('/', $path) as $folder) {
                if (str_contains($folder, '.')) {
                    continue;
                }
                if ($folder == 'templates') {
                    $old_path = $dir . 'templates/';
                    $new_path = $dir . 'subtypes/';
                    $this->rename($old_path, $new_path);
                }
                $dir .= $folder . '/';
            }
        }

        # replacements / assets / js
        $this->replace('resources/assets/js', [
            "import BeltClip from 'belt/content/js/clip';" => '',
            "import BeltGlue from 'belt/glue/js/glue';" => '',
            "BeltClip," => '',
            "BeltGlue," => '',
            'belt/clip/js' => 'belt/content/js',
            'belt/core/js/alerts' => 'belt/notify/js/alerts',
            'belt/core/js/inputs/filter-base' => 'belt/core/js/filters/base',
            'belt/core/js/inputs/filter-search' => 'belt/core/js/filters/search',
            'belt/core/js/inputs/priority/filter' => 'belt/core/js/filters/priority',
            'morphable_' => 'entity_',
        ], true);

        # replacements / assets / sass
        $this->replace('resources/assets/sass', [
            '@import "~belt/clip/sass/base";' => '',
        ], true);

        # replacements / app
        $this->replace('app', [
            'php artisan belt-content:elastic import' => 'php artisan belt-elastic:search upsert',
            'belt-clip::' => 'belt-content::',
            'belt-content:elastic import' => 'belt-elastic:search upsert',
            'Belt\Glue\Elastic\Modifiers\TaggableSortModifier' => 'Belt\Elastic\Modifiers\TermableSortModifier',
            'Belt\Glue\Elastic\Modifiers\CategorizableQueryModifier' => 'Belt\Elastic\Modifiers\TermableQueryModifier',
            'Belt\Glue\Elastic\Modifiers\TaggableQueryModifier' => 'Belt\Elastic\Modifiers\TermableQueryModifier',
            'Belt\Glue\Category' => 'Belt\Content\Term',
            'Belt\Glue\Tag' => 'Belt\Content\Term',
            'Belt\Core\Alert' => 'Belt\Notify\Alert',
            'Belt\Core\Http\ViewComposers\AlertsComposer' => 'Belt\Notify\Http\ViewComposers\AlertsComposer',
            'Belt\Clip' => 'Belt\Content',
            'Belt\Content\Tout' => 'Belt\Content\Block',
            'Belt\Content\Behaviors\IncludesTemplate' => 'Belt\Core\Behaviors\IncludesSubtypes',
            'hasTag(' => 'hasTerm(',
        ], true);

        # replacements / config / subtypes
        $this->replace('config/belt/subtypes', [
            'Belt\Clip' => 'Belt\Content',
            'template' => 'subtype',
        ], true);

        # replacements / config
        $this->replace('config/belt', [
            'belt-clip::' => 'belt-content::',
            'Belt\Clip' => 'Belt\Content',
        ], true);

        # replacements / seeds
        $this->replace('database/seeds', ['template' => 'subtype'], true);

        # replacements / views
        $this->replace('resources/views', [
            'belt-clip::' => 'belt-content::',
            'template_view' => 'subtype_view',
            'Belt\Glue\Category' => 'Belt\Content\Term',
            'Belt\Glue\Tag' => 'Belt\Content\Term',
            'Belt\Clip' => 'Belt\Content',
            'Belt\Core\Alert' => 'Belt\Notify\Alert',
            'Belt\Content\Tout' => 'Belt\Content\Block',
            "->morphParam('albums')" => "->morphParam('lists')",
            "->morphParam('itineraries')" => "->morphParam('lists')",
            "->morphParam('touts')" => "->morphParam('blocks')",
            'hasTag(' => 'hasTerm(',
            'tout->body' => "tout->param('body')",
            'tout->btn_text' => "tout->param('btn_text')",
            '->btn_url' => "->param('btn_url')",
            '->template' => "->subtype",
            "@include('belt-clip::layouts.admin.partials.sidebar-left-nav')" => '',
            "@include('belt-glue::layouts.admin.partials.sidebar-left-nav')" => '',
            "'tag'" => "'term'",
            '$tag' => '$term',
        ], true);
    }

}