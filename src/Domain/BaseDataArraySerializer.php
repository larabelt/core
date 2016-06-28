<?php namespace Ohio\Base\Domain;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\DataArraySerializer;

class BaseDataArraySerializer extends DataArraySerializer
{
    /**
     * Serialize the paginator.
     *
     * @param PaginatorInterface $paginator
     *
     * @return array
     */
    public function paginator(PaginatorInterface $paginator)
    {

        $pagination = parent::paginator($paginator)['pagination'];

        if ($paginator instanceof IlluminatePaginatorAdapter) {
            $pagination['from'] = $paginator->getPaginator()->firstItem();
            $pagination['to'] = $paginator->getPaginator()->lastItem();
        }

        return array('pagination' => $pagination);
    }
}