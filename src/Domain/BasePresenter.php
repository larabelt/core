<?php
namespace Ohio\Core\Domain;

use Prettus\Repository\Presenter\FractalPresenter;

class BasePresenter extends FractalPresenter
{
    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BaseTransformer();
    }
    
    public function serializer()
    {

        $serializer = BaseDataArraySerializer::class;

        return new $serializer();
    }

}