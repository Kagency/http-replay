<?php

namespace Kagency\HttpReplay;

use Kore\DataObject\DataObject;

class SimplifiedResponse extends DataObject
{
    /**
     * Request path
     *
     * @var string
     */
    public $path;

    /**
     * Status code
     *
     * @var int
     */
    public $status;

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
     * @param string $path
     * @param int $status
     * @param array $headers
     * @param mixed $content
     * @return void
     */
    public function __construct($path, $status, array $headers, $content)
    {
        $this->path = $path;
        $this->status = $status;
        $this->headers = $headers;
        $this->content = $content;
    }
}
