<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\SimplifiedResponse;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException UnexpectedValueException
     */
    public function testInvalidJson()
    {
        $response = new SimplifiedResponse('/', 200, array('content-type' => 'application/json'), 'invalid');

        $filter = new Json();
        $filter->filterResponse($response);
    }

    public function testValidJson()
    {
        $response = new SimplifiedResponse('/', 200, array('content-type' => 'application/json'), '[]');

        $filter = new Json();
        $filter->filterResponse($response);

        $this->assertEquals(
            array(),
            $response->content
        );
    }

    public function testJsonObject()
    {
        $response = new SimplifiedResponse('/', 200, array('content-type' => 'application/json'), '{"foo": 42}');

        $filter = new Json();
        $filter->filterResponse($response);

        $this->assertEquals(
            array(
                'foo' => 42,
            ),
            $response->content
        );
    }

    public function testEmptyJsonString()
    {
        $response = new SimplifiedResponse('/', 200, array('content-type' => 'application/json'), '');

        $filter = new Json();
        $filter->filterResponse($response);

        $this->assertEquals(
            null,
            $response->content
        );
    }

    public function testNoJson()
    {
        $response = new SimplifiedResponse('/', 200, array(), '[]');

        $filter = new Json();
        $filter->filterResponse($response);

        $this->assertEquals(
            '[]',
            $response->content
        );
    }
}
