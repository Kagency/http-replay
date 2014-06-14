<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\SimplifiedResponse;

class HeadersTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterNoHeader()
    {
        $filter = new Headers();

        $response = new SimplifiedResponse(
            200,
            array(
                'foo' => 'bar',
            ),
            null
        );
        $filter->filterResponse($response);

        $this->assertSame(
            array(
                'foo' => 'bar',
            ),
            $response->headers
        );
    }

    public function testFilterHeader()
    {
        $filter = new Headers(array('foo'));

        $response = new SimplifiedResponse(
            200,
            array(
                'foo' => 'bar',
                'bar' => 'blubb',
            ),
            null
        );
        $filter->filterResponse($response);

        $this->assertSame(
            array(
                'bar' => 'blubb',
            ),
            $response->headers
        );
    }

    public function testFilterUpperCaseHeader()
    {
        $filter = new Headers(array('Foo'));

        $response = new SimplifiedResponse(
            200,
            array(
                'foo' => 'bar',
                'bar' => 'blubb',
            ),
            null
        );
        $filter->filterResponse($response);

        $this->assertSame(
            array(
                'bar' => 'blubb',
            ),
            $response->headers
        );
    }
}
