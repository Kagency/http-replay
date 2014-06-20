<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\ResponseFilter;
use Kagency\HttpReplay\SimplifiedResponse;

class ConditionalPathRegexp extends ResponseFilter
{
    /**
     * Response filter
     *
     * @var ResponseFilter
     */
    private $aggregate;

    /**
     * Regular expression
     *
     * @var string
     */
    private $regularExpression;

    /**
     * __construct
     *
     * @param string[] $blacklist
     * @return void
     */
    public function __construct($regularExpression, ResponseFilter $aggregate)
    {
        $this->regularExpression = $regularExpression;
        $this->aggregate = $aggregate;
    }

    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return SimplifiedResponse
     */
    public function filterResponse(SimplifiedResponse $response)
    {
        if (preg_match($this->regularExpression, $response->path)) {
            $this->aggregate->filterResponse($response);
        }

        return $response;
    }
}
