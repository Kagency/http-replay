<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\ResponseFilter;
use Kagency\HttpReplay\SimplifiedResponse;

class RemoveKeys extends ResponseFilter
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
        $this->blacklist = $blacklist;
    }

    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return SimplifiedResponse
     */
    public function filterResponse(SimplifiedResponse $response)
    {
        if (!is_array($response->content)) {
            throw new \UnexpectedValueException("Filter only works on array content");
        }

        $response->content = array_diff_key(
            $response->content,
            array_flip($this->blacklist)
        );

        return $response;
    }
}
