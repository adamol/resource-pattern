<?php

namespace Posts;

class OutputResource
{
    private $first;

    private $second;

    public function __construct($first, $second)
    {
        $this->first = $first;

        $this->second = $second;
    }
}

