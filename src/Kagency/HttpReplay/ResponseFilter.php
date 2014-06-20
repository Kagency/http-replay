<?php

namespace Kagency\HttpReplay;

abstract class ResponseFilter
{
    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return SimplifiedResponse
     */
    abstract public function filterResponse(SimplifiedResponse $response);
}
