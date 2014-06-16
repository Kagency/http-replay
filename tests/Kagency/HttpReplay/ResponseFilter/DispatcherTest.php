<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\SimplifiedResponse;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testNoAggregate()
    {
        $filter = new Dispatcher();

        $response = new SimplifiedResponse(200, array(), null);
        $originalResponse = clone $response;
        $filter->filterResponse($response);

        $this->assertEquals(
            $originalResponse,
            $response
        );
    }

    public function testSingleAggregate()
    {
        $response = new SimplifiedResponse(200, array(), null);

        $aggregateFilter = $this->getMock('\\Kagency\\HttpReplay\\ResponseFilter');
        $aggregateFilter
            ->expects($this->once())
            ->method('filterResponse')
            ->with($response);

        $filter = new Dispatcher(array($aggregateFilter));
        $filter->filterResponse($response);
    }

    public function testMultipleAggregates()
    {
        $response = new SimplifiedResponse(200, array(), null);

        $aggregateFilter = $this->getMock('\\Kagency\\HttpReplay\\ResponseFilter');
        $aggregateFilter
            ->expects($this->exactly(2))
            ->method('filterResponse')
            ->with($response);

        $filter = new Dispatcher(array($aggregateFilter, $aggregateFilter));
        $filter->filterResponse($response);
    }
}
