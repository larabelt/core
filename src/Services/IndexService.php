<?php

namespace Belt\Core\Services;

use Belt, Cache, Illuminate, Morph, Schema;
use Belt\Core\Index;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class IndexService
 * @package Belt\Core\Services
 */
class IndexService
{
    use Belt\Core\Behaviors\CanEnable;
    use Belt\Core\Behaviors\HasConsole;
    use Belt\Core\Behaviors\HasPrimaryModel;

    /**
     * @var string
     */
    protected static $primaryModel = Index::class;

//    /**
//     * @var bool
//     */
//    protected static $enabled = false;

    /**
     * @var Model
     */
    private $item;

    /**
     * IndexService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        Index::unguard();
        $this->setConsole(array_get($options, 'console'));
    }

//    /**
//     * Enable service
//     */
//    public static function enable()
//    {
//        self::$enabled = true;
//    }
//
//    /**
//     * Disable service
//     */
//    public static function disable()
//    {
//        self::$enabled = false;
//    }
//
//    /**
//     * Check if service is enabled
//     */
//    public static function isEnabled()
//    {
//        return self::$enabled;
//    }

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
     * @return Model
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return array
     */
    public function data()
    {
        $item = $this->getItem();

        $item->setAppends([]);

        $data = array_except($item->getAttributes(), [
            'id',
            'deleted_at',
        ]);

        return $data;
    }

    /**
     * @return array
     */
    public function columns($force = false)
    {
        $cacheKey = 'index-columns';

        $columns = Cache::get($cacheKey) ?: [];

        if (!$columns || $force) {
            $columns = Schema::getColumnListing('index');
            Cache::put($cacheKey, $columns, 24 * 60);
        }

        return $columns;
    }

    /**
     * @return Index
     */
    public function getIndex()
    {
        $item = $this->getItem();

        return $this->instance()->firstOrCreate([
            'indexable_type' => $item->getMorphClass(),
            'indexable_id' => $item->id,
        ]);
    }

    /**
     * Save index to database
     */
    public function upsert()
    {
        $index = $this->getIndex();

        $columns = $this->columns();

        foreach ($this->data() as $key => $value) {
            if (in_array($key, $columns)) {
                $index->$key = $value;
            }
        }

        $index->save();
    }

    /**
     * @param $id
     * @param $type
     */
    public function delete($id, $type)
    {
        $this->query()
            ->where('indexable_id', $id)
            ->where('indexable_type', $type)
            ->delete();
    }

    /**
     * @param $type
     */
    public function mergeSchema($type)
    {
        $table = Morph::type2Table($type);
        $addedColumns = [];
        $columns = $this->columns(true);
        $newColumns = Schema::getColumnListing($table);

        foreach ($newColumns as $newColumn) {
            if (!in_array($newColumn, $columns)) {
                $columnType = Schema::getColumnType($table, $newColumn);
                Schema::table('index', function (Blueprint $table) use ($columnType, $newColumn) {
                    $method = $columnType;
                    $table->$method($newColumn)->nullable();
                });
                $addedColumns[] = $newColumn;
            }
        }

        $this->info('columns added: ' . implode(', ', $addedColumns));
    }

    /**
     * @param $type
     */
    public function batchUpsert($type)
    {

        $page = 1;
        $limit = 20;

        do {

            $qb = Morph::type2QB($type);

            $items = $qb->take($limit)->orderBy('id')->offset(($page * $limit) - $limit)->get();

            $params['body'] = [];
            foreach ($items as $item) {
                $this->setItem($item)->upsert();
            }

            $this->info("$type Page $page");
            $page++;

        } while ($items->count() == $limit);
    }

}