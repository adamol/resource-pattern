<?php

namespace Posts;

use Symfony\Component\Validator\Constraints as Assert;

class InputResource
{
    /**
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @Assert\NotBlank()
     */
    private $content;

    public function __construct($title, $content)
    {
        $this->title = $title;

        $this->content = $content;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($value)
    {
        $this->content = $value;

        return $this;
    }
}
