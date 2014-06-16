<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\SimplifiedResponse;

class RemoveKeysTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException UnexpectedValueException
     */
    public function testInvalidRemoveKeys()
    {
        $response = new SimplifiedResponse('/', 200, array(), 'invalid');

        $filter = new RemoveKeys();
        $filter->filterResponse($response);
    }

    public function testRemoveKeys()
    {
        $response = new SimplifiedResponse('/', 200, array(), array('foo' => 23, 'bar' => 42));

        $filter = new RemoveKeys(array('foo'));
        $filter->filterResponse($response);

        $this->assertEquals(
            array(
                'bar' => 42,
            ),
            $response->content
        );
    }

    public function testRemoveInexistantKey()
    {
        $response = new SimplifiedResponse('/', 200, array(), array('bar' => 42));

        $filter = new RemoveKeys(array('foo'));
        $filter->filterResponse($response);

        $this->assertEquals(
            array(
                'bar' => 42,
            ),
            $response->content
        );
    }
}
