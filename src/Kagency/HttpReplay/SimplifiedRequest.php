<?php

namespace Kagency\HttpReplay;

use Kore\DataObject\DataObject;

class SimplifiedRequest extends DataObject
{
    /**
     * Method
     *
     * @var string
     */
    public $method;

    /**
     * Request path
     *
     * @var string
     */
    public $path;

    /**
     * Header
     *
     * @var array
     */
    public $headers = array();

    /**
     * Content
     *
     * @var mixed
     */
    public $content;

    /**
     * __construct
     *
     * @param string $method
     * @param string $path
     * @param int $status
     * @param mixed $content
     * @return void
     */
    public function __construct($method, $path, array $headers, $content)
    {
        $this->method = $method;
        $this->path = $path;
        $this->headers = $headers;
        $this->content = $content;
    }
}
