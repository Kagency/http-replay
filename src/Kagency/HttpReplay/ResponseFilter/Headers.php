<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\ResponseFilter;
use Kagency\HttpReplay\SimplifiedResponse;

class Headers extends ResponseFilter
{
    /**
     * Header blacklist
     *
     * @var string[]
     */
    private $blacklist = array();

    /**
     * __construct
     *
     * @param string[] $blacklist
     * @return void
     */
    public function __construct(array $blacklist = array())
    {
        $this->blacklist = array_map('strtolower', $blacklist);
    }

    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return void
     */
    public function filterResponse(SimplifiedResponse $response)
    {
        $response->headers = array_diff_key(
            $response->headers,
            array_flip($this->blacklist)
        );
    }
}
