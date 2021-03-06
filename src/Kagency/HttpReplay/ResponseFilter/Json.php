<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\ResponseFilter;
use Kagency\HttpReplay\SimplifiedResponse;

class Json extends ResponseFilter
{
    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return SimplifiedResponse
     */
    public function filterResponse(SimplifiedResponse $response)
    {
        if (isset($response->headers['content-type']) &&
            ($response->headers['content-type'] === 'application/json')) {
            if ($response->content === "") {
                $response->content = null;
                return;
            }

            $decoded = json_decode($response->content, true);
            if ($decoded === null) {
                throw new \UnexpectedValueException("Invalid JSON in JSON response: $response->content");
            }

            $response->content = $decoded;
        }

        return $response;
    }
}
