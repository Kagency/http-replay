<?php

namespace Kagency\HttpReplay\ResponseFilter;

use Kagency\HttpReplay\SimplifiedResponse;

class ConditionalPathRegexpTest extends \PHPUnit_Framework_TestCase
{
    public function testPathMatchesRegexp()
    {
        $response = new SimplifiedResponse('/path', 200, array(), null);
        $aggregateFilter = $this->getMock('\\Kagency\\HttpReplay\\ResponseFilter');
        $aggregateFilter
            ->expects($this->once())
            ->method('filterResponse')
            ->with($response);

        $filter = new ConditionalPathRegexp('(^/path)', $aggregateFilter);
        $filter->filterResponse($response);
    }

    public function testPathDoesNotMatchRegexp()
    {
        $response = new SimplifiedResponse('/path', 200, array(), null);
        $aggregateFilter = $this->getMock('\\Kagency\\HttpReplay\\ResponseFilter');
        $aggregateFilter
            ->expects($this->never())
            ->method('filterResponse')
            ->with($response);

        $filter = new ConditionalPathRegexp('(^/doesNotMatch)', $aggregateFilter);
        $filter->filterResponse($response);
    }
}
