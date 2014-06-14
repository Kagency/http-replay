<?php

namespace Kagency\HttpReplay;

abstract class ResponseFilter
{
    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return void
     */
    abstract public function filterResponse(SimplifiedResponse $response);
}
