<?php
namespace Ohio\Core\Base;

use Illuminate\Database\Eloquent\Model;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class BaseModel extends Model
{

    protected $guarded = ['id'];

    public function __toString()
    {
        return (string) $this->id;
    }

}