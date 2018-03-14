<?php

use Belt\Core\Behaviors\HasDisk;
use Belt\Core\Helpers\DebugHelper;
use Belt\Core\Services\Update\BaseUpdate;
use Belt\Content\Section;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class BeltUpdateTemplates1 extends BaseUpdate
{
    use HasDisk;

    /**
     *
     */
    public function up()
    {
        foreach (config('belt.templates-old') as $morphClass => $templates) {
            foreach ($templates as $key => $template) {
                $this->update($morphClass, $key, $template);
            }
        }
    }

    public function update($morphClass, $templateKey, $old)
    {
        $this->info(sprintf('%s:%s', $morphClass, $templateKey));

        $for = in_array($morphClass, ['pages', 'categories', 'places', 'posts', 'events']) ? $morphClass : 'sections';

        $params = array_get($old, 'params', []);

        $new = [
            'builder' => array_get($old, 'builder', null),
            'extends' => array_get($old, 'extends', ''),
            'path' => array_get($old, 'path', ''),
            'label' => array_get($old, 'label', ''),
            'description' => array_get($old, 'description', ''),
        ];

        if ($for == 'sections') {
            $qb = Section::where('sectionable_type', $morphClass)->where('template', $templateKey);
            foreach (['heading', 'before', 'after'] as $column) {
                $clone = clone $qb;
                $clone->where(function ($qb) use ($column) {
                    $qb->whereNotNull($column);
                    $qb->orWhere($column, '!=', '');
                });
                $new[$column] = $clone->first() ? true : false;
            }
        }

        if ($params) {
            foreach ($params as $key => $values) {
                $new['params'][$key] = [
                    'type' => is_array($values) ? 'select' : 'text',
                    'class' => null,
                    'validation' => '',
                    'plugin' => '',
                    'options' => is_array($values) ? $values : null,
                    'label' => '',
                    'description' => '',
                ];
            }
            asort($new['params']);
        }

        $path = sprintf('config/belt/templates-new/%s/%s.php', $morphClass, $templateKey);

        Section::unguard();
        if ($for == 'sections') {
            $newMorphClass = $morphClass == 'sections' ? 'containers' : $morphClass;
            Section::where('sectionable_type', $morphClass)
                ->where('template', $templateKey)
                ->update([
                    'sectionable_type' => in_array($morphClass, ['custom', 'sections', 'containers']) ? null : $morphClass,
                    'template' => sprintf('%s.%s', $newMorphClass, $templateKey),
                ]);
            dump([
                'sectionable_type' => in_array($morphClass, ['custom', 'sections', 'containers']) ? null : $morphClass,
                'template' => sprintf('%s.%s', $newMorphClass, $templateKey),
            ]);
            $path = sprintf('config/belt/templates-new/%s/%s/%s.php', $for, $newMorphClass, $templateKey);
        }

        $contents = sprintf("<?php\r\n\r\nreturn %s;", DebugHelper::varExportShort($new));
        //$this->disk()->put($path, $contents);

    }

}