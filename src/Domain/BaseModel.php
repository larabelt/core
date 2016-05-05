<?php
namespace Ohio\Base\Domain;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BaseModel extends Model implements Transformable
{

    use TransformableTrait;

    protected $guarded = ['id'];

    public function __toString()
    {
        return (string) $this->id;
    }
}