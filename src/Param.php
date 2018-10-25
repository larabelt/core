<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Param
 * @package Belt\Core
 */
class Param extends Model implements
    Belt\Core\Behaviors\TranslatableInterface,
    Belt\Core\Behaviors\TypeInterface
{
    use Belt\Core\Behaviors\Translatable;
    use Belt\Core\Behaviors\TypeTrait;

    /**
     * @var string
     */
    protected $morphClass = 'params';

    /**
     * @var string
     */
    protected $table = 'params';

    /**
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * @var array
     */
    protected $appends = ['morph_class'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function paramable()
    {
        return $this->morphTo('paramable');
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        $config = [];

        if ($this->paramable) {
            if ($this->paramable instanceof Belt\Core\Behaviors\ParamableInterface) {
                $config = $this->paramable->getParamConfig();
            }
        }

        return array_get($config, $this->key, []);
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        $config = $this->getConfig();

        return $config[$key] ?? $default;
    }

    /**
     * @return mixed
     */
    public function getTranslatable()
    {
        return $this->config('translatable') ? 'value' : null;
    }

    /**
     * @param $value
     */
    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = strtolower(trim($value));
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = trim($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getValueAttribute($value)
    {
        $value = trim($value);

        $value = strtolower($value) == 'true' ? true : $value;
        $value = strtolower($value) == 'false' ? false : $value;

        return $value;
    }

    /**
     * @param $param
     * @param array $options
     * @return Model
     */
    public static function copy($param, $options = [])
    {
        $param = $param instanceof Param ? $param : self::find($param)->first();

        $clone = $param->replicate();
        $clone->paramable_id = array_get($options, 'paramable_id');
        $clone->save();

        return $clone;
    }

}