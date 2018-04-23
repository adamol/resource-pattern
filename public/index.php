<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application;

$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['hydrator'] = function() {
    return new Zend\Hydrator\Reflection();
};

$app['framework.hydrator'] = function($app) {
    return new Framework\Hydrator($app['hydrator']);
};

$app['validator'] = function() {
    return Symfony\Component\Validator\Validation::createValidator();
};

$app['posts.controller'] = function($app) {
    return new Posts\Controller($app['framework.hydrator'], $app['validator']);
};

$app->get('/', 'posts.controller:index');

$app->run();
