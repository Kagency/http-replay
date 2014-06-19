<?php

namespace Kagency\HttpReplay;

use Kore\DataObject\DataObject;

class Interaction extends DataObject
{
    /**
     * Recorded request
     *
     * @var mixed
     */
    public $request;

    /**
     * Recorded response
     *
     * @var mixed
     */
    public $response;

    /**
     * __construct
     *
     * @param mixed $request
     * @param mixed $response
     * @return void
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
