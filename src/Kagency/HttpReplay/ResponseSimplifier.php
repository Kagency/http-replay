<?php

namespace Kagency\HttpReplay;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseSimplifier
{
    /**
     * Simplify Symfony2 response
     *
     * @param Response $response
     * @return SimplifiedResponse
     */
    public function simplifyResponse(Request $request, Response $response)
    {
        return new SimplifiedResponse(
            $request->getPathInfo(),
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
