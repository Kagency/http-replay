<?php

namespace Kagency\HttpReplay;

abstract class Reader
{
    /**
     * Read interactions l
     *
     * @param string $file
     * @return Interaction[]
     */
    abstract public function readInteractions($file);
}
