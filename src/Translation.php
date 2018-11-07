<?php

namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 * @package Belt\Core
 */
class Translation extends Model
    implements Belt\Core\Behaviors\IncludesLocaleInterface
{
    use Belt\Core\Behaviors\IncludesLocale;

    /**
     * @var string
     */
    protected $morphClass = 'translations';

    /**
     * @var string
     */
    protected $table = 'translations';

    /**
     * @var array
     */
    protected $fillable = ['locale', 'translatable_column', 'value'];

    /**
     * @param $translation
     * @param array $options
     * @return Model
     */
    public static function copy($translation, $options = [])
    {
        $translation = $translation instanceof Translation ? $translation : self::find($translation)->first();

        $clone = $translation->replicate();
        $clone->translatable_id = array_get($options, 'translatable_id');
        $clone->save();

        return $clone;
    }

}