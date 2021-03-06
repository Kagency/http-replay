<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\SimplifiedResponse;

class MultipartMixedTest extends \PHPUnit_Framework_TestCase
{
    public function testValidMultipartMixedReplaceContent()
    {
        $response = new SimplifiedResponse(
            '/',
            200,
            array(
                'content-type' => 'multipart/mixed; boundary="f00"',
            ),
            '-- f00 --'
        );

        $filter = new MultipartMixed();
        $filter->filterResponse($response);

        $this->assertEquals(
            '-- <boundary> --',
            $response->content
        );
    }

    public function testValidMultipartMixedReplaceHeader()
    {
        $response = new SimplifiedResponse(
            '/',
            200,
            array(
                'content-type' => 'multipart/mixed; boundary="f00"',
            ),
            '-- f00 --'
        );

        $filter = new MultipartMixed();
        $filter->filterResponse($response);

        $this->assertEquals(
            'multipart/mixed; boundary="<boundary>"',
            $response->headers['content-type']
        );
    }

    public function testNoMultipartMixed()
    {
        $response = new SimplifiedResponse('/', 200, array(), '[]');

        $filter = new MultipartMixed();
        $filter->filterResponse($response);

        $this->assertEquals(
            '[]',
            $response->content
        );
    }
}
