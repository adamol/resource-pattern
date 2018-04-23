<?php

namespace Framework;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ResourceArgumentValueResolver implements ArgumentValueResolverInterface
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return null !== $argument->getType() &&
            is_subclass_of($argument->getType(), Resource::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        switch (strtoupper($request->getMethod())) {
            case 'GET':
                $data = $request->query->all();
                break;
            case 'POST':
                $data = $request->request->all();
                break;
        }

        $input = $this->app['framework.hydrator']->hydrate(
            $data,
            $argument->getType()
        );

        $errors = $this->app['validator']->validate($input);

        if (count($errors) > 0) {
            throw new \Exception((string) $errors);
        }

        yield $input;
    }
}
