<?php

namespace Kagency\HttpReplay\MessageHandler;

use Kagency\HttpReplay\MessageHandler;
use Kagency\HttpReplay\SimplifiedRequest;
use Kagency\HttpReplay\SimplifiedResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Symfony2 extends MessageHandler
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
    public function convertFromRequest(SimplifiedRequest $request)
    {
        return Request::create(
            $request->path,
            $request->method,
            array(),
            array(),
            array(),
            $this->mapHeaderKeys($request->headers),
            $request->content
        );
    }

    /**
     * Map header keys
     *
     * @param array $headers
     * @return array
     */
    protected function mapHeaderKeys(array $headers)
    {
        $phpHeaders = array();
        foreach ($headers as $key => $value) {
            $phpHeaders['HTTP_' . str_replace('-', '_', strtoupper($key))] = $value;
        }

        return $phpHeaders;
    }

    /**
     * Convert from simplified response
     *
     * Converts a simplified response into the response structure you need for
     * your current framework.
     *
     * @param SimplifiedResponse $response
     * @return mixed
     */
    public function convertFromResponse(SimplifiedResponse $response)
    {
        return Response::create(
            $response->content,
            $response->status,
            $response->headers
        );
    }

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
    public function simplifyResponse($request, $response)
    {
        if (!$request instanceof Request) {
            throw new \UnexpectedValueException("Expected a Symfony2 request object.");
        }

        if (!$response instanceof Response) {
            throw new \UnexpectedValueException("Expected a Symfony2 response object.");
        }

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
