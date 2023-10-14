<?php

namespace Skeleton\Library;

/**
 * Pagination.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Pagination
{
    protected $config;

    /**
     * Construct
     */
    function __construct()
    {
        $this->config = \Phalcon\Di\Di::getDefault()->get('config');
    }

    /**
     * @param array $data
     * @param int $page
     * @return array
     */
    public function pager(array $data = [], int $page = 1)
    {
        $paginator = new \Phalcon\Paginator\Adapter\NativeArray([
            'data'  => $data,
            'limit' => $this->config->pagination->perpage,
            'page'  => $page,
        ]);

        $items = ['items' => '', 'allItemsCount' => ''];
        if ($paginator->paginate()->getItems()) {
            $items = $paginator->paginate()->getItems();
        }

        return [
            'items'           => $paginator->paginate()->getItems(),
            'pager'           => [
                'all_items_count' => $paginator->paginate()->getTotalItems(),
                'total_pages'     => \ceil($paginator->paginate()->getTotalItems() / $this->config->pagination->perpage),
                'total_items'     => $paginator->paginate()->getTotalItems(),
                'limit'           => $paginator->paginate()->getLimit(),
                'first'           => $paginator->paginate()->getFirst(),
                'previous'        => $paginator->paginate()->getPrevious(),
                'current'         => $paginator->paginate()->getCurrent(),
                'next'            => $paginator->paginate()->getNext(),
                'last'            => $paginator->paginate()->getLast()
            ]
        ];
    }
}
