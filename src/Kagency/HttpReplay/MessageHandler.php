<?php

namespace Kagency\HttpReplay;

abstract class MessageHandler
{
    /**
     * Convert from simplified request
     *
     * Converts a simplified request into the request structure you need for
     * your current framework.
     *
     * @param SimplifiedRequest $request
     * @return mixed
     */
    abstract public function convertFromRequest(SimplifiedRequest $request);

    /**
     * Convert from simplified response
     *
     * Converts a simplified response into the response structure you need for
     * your current framework.
     *
     * @param SimplifiedResponse $response
     * @return mixed
     */
    abstract public function convertFromResponse(SimplifiedResponse $response);

    /**
     * Simplify response
     *
     * Return a simplified response for the given set of request and response.
     * Usually constructed from your frameworks response.
     *
     * @param mixed $request
     * @param mixed $response
     * @return SimplifiedResponse
     */
    abstract public function simplifyResponse($request, $response);
}
