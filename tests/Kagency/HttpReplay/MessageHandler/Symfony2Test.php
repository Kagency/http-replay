<?php

namespace Kagency\HttpReplay\MessageHandler;

use Kagency\HttpReplay\SimplifiedRequest;
use Kagency\HttpReplay\SimplifiedResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Symfony2Test extends \PHPUnit_Framework_TestCase
{
    public function testCreateSymfonyRequest()
    {
        $messageHandler = new Symfony2();

        $this->assertEquals(
            Request::create(
                '/path',
                'GET',
                array(),
                array(),
                array(),
                array(
                    'HTTP_CONTENT_TYPE' => 'application/json',
                ),
                '[]'
            ),
            $messageHandler->convertFromRequest(
                new SimplifiedRequest(
                    'GET',
                    '/path',
                    array(
                        'content-type' => 'application/json'
                    ),
                    '[]'
                )
            )
        );
    }

    public function testCreateSymfonyResponse()
    {
        $messageHandler = new Symfony2();

        $this->assertEquals(
            Response::create(
                '[]',
                200,
                array(
                    'content-type' => 'application/json',
                )
            ),
            $messageHandler->convertFromResponse(
                new SimplifiedResponse(
                    '/path',
                    200,
                    array(
                        'content-type' => 'application/json'
                    ),
                    '[]'
                )
            )
        );
    }

    public function testSimplifyResponse()
    {
        $messageHandler = new Symfony2();

        $this->assertEquals(
            new SimplifiedResponse(
                '/path',
                200,
                array(
                    'header' => 'Value',
                    'cache-control' => 'no-cache',
                    'date' => gmdate('D, d M Y H:i:s T'),
                ),
                'content'
            ),
            $messageHandler->simplifyResponse(
                Request::create(
                    '/path'
                ),
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
