<?php

$loader = require __DIR__.'/../vendor/autoload.php';

use Silex\AppArgumentValueResolver;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app = new Silex\Application;

$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new ValidatorServiceProvider());

$app['argument_value_resolvers'] = function($app) {
    return array_merge([
        new AppArgumentValueResolver($app),
        new Framework\ResourceArgumentValueResolver($app)
    ], ArgumentResolver::getDefaultArgumentValueResolvers());
};

$app['validator.mapping.class_metadata_factory'] = function ($app) {
    $loader = new AnnotationLoader(new AnnotationReader());

    return new LazyLoadingMetadataFactory($loader);
};


$app['hydrator'] = function() {
    return new Zend\Hydrator\Reflection();
};

$app['framework.hydrator'] = function($app) {
    return new Framework\Hydrator($app['hydrator']);
};

$app['posts.controller'] = function($app) {
    return new Posts\Controller($app['framework.hydrator'], $app['validator']);
};

$app->on(Symfony\Component\HttpKernel\KernelEvents::VIEW, function (Symfony\Component\HttpKernel\Event\GetResponseEvent $event) use ($app) {
    $value = $event->getControllerResult();

    $response = new JsonResponse($app['framework.hydrator']->extract($value));

    $event->setResponse($response);
});

$app->get('/', 'posts.controller:index');

$app->run();
