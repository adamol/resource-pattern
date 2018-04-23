<?php

namespace Posts;

class InputResource
{
    private $title;

    private $content;

    public function __construct($title, $content)
    {
        $this->title = $title;

        $this->content = $content;
    }
}
