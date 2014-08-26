<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

// Controller resolving
$app['resolver'] = $app->share(function() use ($app) {
    return new \Wecamp\Recall\Controller\ControllerResolver($app);
});

// Controllers
$app['timeline.controller'] = $app->share(function() use ($app) {
    return new \Wecamp\Recall\Controller\TimelineController();
});

// Routing
$app->get('/', 'timeline.controller:listAction');

$app->run();