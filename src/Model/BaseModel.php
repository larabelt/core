<?php
namespace Ohio\Base\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected $guarded = ['id'];

    public function __toString()
    {
        return $this->id;
    }
}