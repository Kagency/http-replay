<?php

namespace Kagency\HttpReplay;

use Symfony\Component\HttpFoundation\Response;

class ResponseSimplifierTest extends \PHPUnit_Framework_TestCase
{
    public function testSimplifyResponse()
    {
        $simplifier = new ResponseSimplifier();

        $this->assertEquals(
            new SimplifiedResponse(
                200,
                array(
                    'header' => 'Value',
                    'cache-control' => 'no-cache',
                    'date' => gmdate('D, d M Y H:i:s T'),
                ),
                'content'
            ),
            $simplifier->simplifyResponse(
                Response::create(
                    'content',
                    200,
                    array(
                        'Header' => 'Value',
                    )
                )
            )
        );
    }
}
