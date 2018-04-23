<?php

namespace Posts;

use Symfony\Component\HttpFoundation\JsonResponse;

class Controller
{
    private $hydrator;

    private $validator;

    public function __construct($hydrator, $validator)
    {
        $this->hydrator = $hydrator;
        $this->validator = $validator;
    }

    public function index()
    {
        $data = [
            'title' => 'Some Title',
            'content' => 'Lorem ipsum dolor sit amet...'
        ];
        $input = new InputResource($data['title'], $data['content']);

        $input = $this->hydrator->hydrate($data, InputResource::class);

        $errors = $this->validator->validate($input);
        //$errors = $this->validator->validate(new InputResource('', ''));

        if (count($errors) > 0) {
            var_dump((string) $errors);
        }

        // use $input to call services etc
        // grab return values from services to return to user

        $output = new OutputResource('foo', 'bar');

        return new JsonResponse($this->hydrator->extract($output));
    }
}
