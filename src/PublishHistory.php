<?php
namespace Belt\Core;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PublishHistory
 * @package Belt\Core
 */
class PublishHistory extends Model
{
    /**
     * @var string
     */
    protected $table = 'publish_history';

    /**
     * @var array
     */
    protected $fillable = ['path', 'hash'];
}