<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\ResponseFilter;
use Kagency\HttpReplay\SimplifiedResponse;

class Dispatcher extends ResponseFilter
{
    /**
     * Aggregated filters
     *
     * @var ResponseFilter[]
     */
    private $filters = array();

    /**
     * __construct
     *
     * @param string[] $blacklist
     * @return void
     */
    public function __construct(array $filters = array())
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * Add filter
     *
     * @param ResponseFilter $filter
     * @return void
     */
    public function addFilter(ResponseFilter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return void
     */
    public function filterResponse(SimplifiedResponse $response)
    {
        foreach ($this->filters as $filter) {
            $filter->filterResponse($response);
        }
    }
}
