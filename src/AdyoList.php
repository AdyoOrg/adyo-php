<?php

namespace Adyo;

class AdyoList {

    /**
     * The objects in the current list
     *
     * @var array
     */
    public $objects = [];

    /**
     * The total number of objects outside the scope of the list
     *
     * @var int
     */
    public $total = 0;

    /**
     * The number of objects in the current list
     *
     * @var int
     */
    public $count = 0;

    /**
     * The number of items per page that produced this list
     *
     * @var int
     */
    public $per_page = 0;

    /**
     * The current page that produced this list
     *
     * @var int
     */
    public $current_page = 0;

    /**
     * The total number of pages outside the scope of this list
     *
     * @var int
     */
    public $total_pages = 0;

    /**
     * The next URL to fetch the next page
     *
     * @var string
     */
    public $next_url = null;

    /**
     * The previous URL to fetch the previous page
     *
     * @var string
     */
    public $prev_url = null;

    /**
     * Constructs a simple list item to whole our page
     *
     * @param array $objects The objects in the list
     * @param int $total The total number of objects outside the scope of the list
     * @param int $count The number of objects in the current list
     * @param int $perPage The number of items per page that produced this list
     * @param int $currentPage The current page that produced this list
     * @param int $totalPages The total number of pages outside the scope of this list
     * @param string $nextUrl The next URL to fetch the next page
     * @param string $prevUrl The previous URL to fetch the previous page
     * @return void
     */
    public function __construct($objects, 
                                $total, 
                                $count,
                                $perPage,
                                $currentPage,
                                $totalPages,
                                $nextUrl, 
                                $prevUrl) {

        $this->objects = $objects;
        $this->total = $total;
        $this->count = $count;
        $this->per_page = $perPage;
        $this->current_page = $currentPage;
        $this->total_pages = $totalPages;
        $this->next_url = $nextUrl;
        $this->prev_url = $prevUrl;
    }
}