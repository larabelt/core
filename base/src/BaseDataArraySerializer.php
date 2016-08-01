<?php namespace Ohio\Core\Base;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\DataArraySerializer;

class BaseDataArraySerializer extends DataArraySerializer
{

    public $paginator;

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
            $this->paginator = $paginator;
            $pagination['from'] = $paginator->getPaginator()->firstItem();
            $pagination['to'] = $paginator->getPaginator()->lastItem();
        }

        return array('pagination' => $pagination);
    }

    /**
     * Serialize the meta.
     *
     * @param array $meta
     *
     * @return array
     */
    public function meta(array $meta)
    {
        if (empty($meta)) {
            return array();
        }

        if ($this->paginator && $this->paginator instanceof IlluminatePaginatorAdapter) {
//            s($this->paginator->getPaginator()->query);
//            exit;
//            $meta['query'] = $this->paginator->getPag;
        }

        return array('meta' => $meta);
    }
}