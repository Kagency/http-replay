<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\ResponseFilter;
use Kagency\HttpReplay\SimplifiedResponse;

/**
 * Class: JsonFilter
 *
 * @IDEA Make it possible to filter deep properties with something like
 * JSON-path.
 *
 * @version $Revision$
 */
class JsonFilter extends ResponseFilter
{
    /**
     * Json property blacklist
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
            return;
        }

        $response->content = array_diff_key(
            $response->content,
            array_flip($this->blacklist)
        );

        return $response;
    }
}
