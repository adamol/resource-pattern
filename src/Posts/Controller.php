<?php

namespace Posts;

class Controller
{
    public function index(InputResource $input)
    {
        // use $input to call services etc
        // grab return values from services to return to user

        return new OutputResource(
            strtoupper($input->getTitle()), // just showing that
            md5($input->getContent())       // we can do what we want here
        );
    }
}
