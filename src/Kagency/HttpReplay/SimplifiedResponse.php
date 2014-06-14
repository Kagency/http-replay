<?php

namespace Kagency\HttpReplay;

use Kore\DataObject\DataObject;

class SimplifiedResponse extends DataObject
{
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
    public $header = array();

    /**
     * Content
     *
     * @var mixed
     */
    public $content;

    /**
     * __construct
     *
     * @param int $status
     * @param array $headers
     * @param mixed $content
     * @return void
     */
    public function __construct($status, array $headers, $content)
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->content = $content;
    }
}
