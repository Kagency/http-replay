<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\SimplifiedResponse;

class JsonFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterProperty()
    {
        $filter = new JsonFilter(array('bar'));

        $response = new SimplifiedResponse(
            '/',
            200,
            array(),
            array(
                'foo' => 'bar',
                'bar' => 'blubb',
            )
        );
        $filter->filterResponse($response);

        $this->assertSame(
            array(
                'foo' => 'bar',
            ),
            $response->content
        );
    }

    public function testFilterInexistantProperty()
    {
        $filter = new JsonFilter(array('inexistant'));

        $response = new SimplifiedResponse(
            '/',
            200,
            array(),
            array(
                'bar' => 'blubb',
            )
        );
        $filter->filterResponse($response);

        $this->assertSame(
            array(
                'bar' => 'blubb',
            ),
            $response->content
        );
    }

    public function testFilterInvalidContent()
    {
        $filter = new JsonFilter(array('Foo'));

        $response = new SimplifiedResponse(
            '/',
            200,
            array(),
            'untouched'
        );
        $filter->filterResponse($response);

        $this->assertSame(
            'untouched',
            $response->content
        );
    }
}
