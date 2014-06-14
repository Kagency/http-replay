<?php

namespace Kagency\HttpReplay;

use Symfony\Component\HttpFoundation\Response;

class ResponseSimplifier
{
    /**
     * Simplify Symfony2 response
     *
     * @param Response $response
     * @return SimplifiedResponse
     */
    public function simplifyResponse(Response $response)
    {
        return new SimplifiedResponse(
            $response->getStatusCode(),
            array_map(
                function ($value) {
                    return reset($value);
                },
                iterator_to_array($response->headers)
            ),
            $response->getContent()
        );
    }
}
