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
        foreach (config('belt.templates') as $morph_class => $templates) {
            foreach ($templates as $key => $template) {
                $this->update($morph_class, $key, $template);
                break 2;
            }
        }
    }

    public function update($morph_class, $templateKey, $old)
    {
        $this->info(sprintf('%s:%s', $morph_class, $templateKey));

        if (array_has($old, 'for')) {
            //return;
        }

        $params = array_get($old, 'params', []);

        $new = [
            'for' => $templateKey == 'pages' ? 'pages' : 'sections',
            'builder' => array_get($old, 'builder', null),
            'extends' => array_get($old, 'extends', ''),
            'path' => array_get($old, 'path', ''),
            'label' => array_get($old, 'label', ''),
            'description' => array_get($old, 'description', ''),
        ];

        if ($new['for'] == 'sections') {
            $qb = Section::where('sectionable_type', $morph_class)->where('template', $templateKey);
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

        $path = sprintf('config/belt/templates-new/%s/%s.php', $morph_class, $templateKey);
        $contents = sprintf("<?php\r\n\r\nreturn %s;", DebugHelper::varExportShort($new));

        $this->disk()->put($path, $contents);
    }

}