<?php

namespace Kagency\HttpReplay;

use Kore\DataObject\DataObject;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Interaction extends DataObject
{
    /**
     * Recorded request
     *
     * @var Request
     */
    public $request;

    /**
     * Recorded response
     *
     * @var Response
     */
    public $response;

    /**
     * __construct
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
