<?php

use Belt\Core\Behaviors\HasDisk;
use Belt\Core\Helpers\DebugHelper;
use Belt\Core\Services\Update\BaseUpdate;
use Belt\Content\Section;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class BeltUpdateTemplates extends BaseUpdate
{
    use HasDisk;

    /**
     * @var array
     */
    public $argumentMap = [
        'method',
    ];

    public function up()
    {
        $method = $this->argument('method');
        $method = camel_case($method);
        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    /**
     * @param $morphClass
     * @return string
     */
    public function getTemplateType($morphClass)
    {
        $type = in_array($morphClass, ['pages', 'categories', 'places', 'posts', 'events']) ? $morphClass : 'sections';

        return $type;
    }

    /**
     * @param $morphClass
     * @param $templateKey
     * @param $oldConfig
     * @return array
     */
    public function getNewConfig($morphClass, $templateKey, $oldConfig)
    {
        $type = $this->getTemplateType($morphClass);

        $params = array_get($oldConfig, 'params', []);

        $newConfig = [
            'builder' => array_get($oldConfig, 'builder', null),
            'extends' => array_get($oldConfig, 'extends', ''),
            'path' => array_get($oldConfig, 'path', ''),
            'label' => array_get($oldConfig, 'label', ''),
            'description' => array_get($oldConfig, 'description', ''),
        ];

        if ($type == 'sections') {
            $qb = Section::where('sectionable_type', $morphClass)->where('template', $templateKey);
            foreach (['heading', 'before', 'after'] as $column) {
                $clone = clone $qb;
                $clone->where(function ($qb) use ($column) {
                    $qb->whereNotNull($column);
                    $qb->orWhere($column, '!=', '');
                });
                $newConfig[$column] = $clone->first() ? true : false;
            }
        }

        if ($params) {
            foreach ($params as $key => $values) {
                $newConfig['params'][$key] = [
                    'type' => is_array($values) ? 'select' : 'text',
                    'class' => null,
                    'validation' => '',
                    'plugin' => '',
                    'options' => is_array($values) ? $values : null,
                    'label' => '',
                    'description' => '',
                ];
            }
            asort($newConfig['params']);
        }

        return $newConfig;
    }

    public function organize()
    {
        $configKey = $this->option('configKey', 'belt.templates');

        foreach (config($configKey) as $morphClass => $templates) {
            foreach ($templates as $templateKey => $config) {
                $this->__organize($morphClass, $templateKey, $config);
            }
        }
    }

    public function __organize($morphClass, $templateKey, $oldConfig)
    {
        $this->info(sprintf('re-organize %s:%s', $morphClass, $templateKey));

        $type = $this->getTemplateType($morphClass);

        $newConfig = $this->getNewConfig($morphClass, $templateKey, $oldConfig);

        $path = sprintf('config/belt/templates-new/%s/%s.php', $morphClass, $templateKey);

        if ($type == 'sections') {
            $morphClass = $morphClass == 'sections' ? 'containers' : $morphClass;
            $path = sprintf('config/belt/templates-new/%s/%s/%s.php', $type, $morphClass, $templateKey);
        }

        $contents = sprintf("<?php\r\n\r\nreturn %s;", DebugHelper::varExportShort($newConfig));
        $this->disk()->put($path, $contents);
    }

    public function rename()
    {
        $newPath = $this->option('new-path', 'templates-new');
        $newPath = config_path('belt/' . $newPath);
        if ($newPath && file_exists($newPath)) {
            $targetPath = $this->option('target-path', 'templates');
            $targetPath = config_path('belt/' . $targetPath);
            if ($targetPath) {
                if (file_exists($targetPath)) {
                    $archivedPath = "$targetPath-archived";
                    rename($targetPath, $archivedPath);
                    $this->info('moved existing path to: ', $archivedPath);
                }
                rename($newPath, $targetPath);
                $this->info('moved new path to: ', $targetPath);
            }
        }
    }

    public function updateDB()
    {
        Section::unguard();

        $configKey = $this->option('configKey', 'belt.templates.sections');

        foreach (config($configKey) as $morphClass => $templates) {
            foreach ($templates as $templateKey => $config) {
                $this->__updateDB($morphClass, $templateKey);
            }
        }

        Section::whereNull('sectionable_id')->update(['sectionable_type' => null]);
    }

    public function __updateDB($morphClass, $templateKey)
    {
        $this->info(sprintf('update sections db: %s %s', $morphClass, $templateKey));

        $oldSectionableType = $morphClass;
        if (in_array($oldSectionableType, ['containers'])) {
            $oldSectionableType = 'sections';
        }

        $newTemplateKey = sprintf('%s.%s', $morphClass, $templateKey);
        Section::whereNotNull('sectionable_type')
            ->where('sectionable_type', $oldSectionableType)
            ->where('template', $templateKey)->update(['template' => $newTemplateKey]);

    }

}