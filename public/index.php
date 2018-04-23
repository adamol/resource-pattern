<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['posts.controller'] = function() {
    return new Posts\Controller;
};

$app->get('/', 'posts.controller:index');

$app->run();
