<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\ResponseFilter;
use Kagency\HttpReplay\SimplifiedResponse;

class MultipartMixed extends ResponseFilter
{
    /**
     * Filter response
     *
     * @param SimplifiedResponse $response
     * @return void
     */
    public function filterResponse(SimplifiedResponse $response)
    {
        if (isset($response->headers['content-type']) &&
            preg_match(
                '(^multipart/mixed; boundary="(?P<boundary>[a-f0-9]+)"$)',
                $response->headers['content-type'],
                $match
            )) {

            $response->headers['content-type'] = str_replace(
                $match['boundary'],
                '<boundary>',
                $response->headers['content-type']
            );

            $response->content = str_replace(
                $match['boundary'],
                '<boundary>',
                $response->content
            );

            // @IDEA: split body into sub-responses and re-run the filters on
            // them?
        }
    }
}
