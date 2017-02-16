<?php
namespace Belt\Core;

use Illuminate\Database\Eloquent\Model;

class PublishHistory extends Model
{
    protected $table = 'publish_history';

    protected $fillable = ['path', 'hash'];
}