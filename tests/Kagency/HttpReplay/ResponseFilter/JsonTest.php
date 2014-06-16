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
