<?php

namespace Framework;

class Hydrator
{
    private $hydrator;

    public function __construct($hydrator)
    {

        $this->hydrator = $hydrator;
    }

    public function hydrate($data, $class)
    {
        return $this->hydrator->hydrate(
            $data,
            (new \ReflectionClass($class))->newInstanceWithoutConstructor()
        );
    }

    public function extract($instance)
    {
        return $this->hydrator->extract($instance);
    }
}

