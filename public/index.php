<?php

$loader = require __DIR__.'/../vendor/autoload.php';

use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app = new Silex\Application;

$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new ValidatorServiceProvider());

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

$app->get('/', 'posts.controller:index');

$app->run();
