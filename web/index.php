<?php

// Static files workaround
$filename = dirname(__FILE__).preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

// Recall
$app['recall.data_dir'] = dirname(__FILE__) . '/../var/data/repo';
$app->register(new \Wecamp\Recall\Provider\RecallServiceProvider());

// GitWrapper
$app->register(new \Wecamp\Recall\Provider\GitWrapperServiceProvider(array(
    'git_wrapper.home' => dirname(__FILE__) . '/../var/data'
)));

// Controller resolving
$app['resolver'] = $app->share(function() use ($app) {
    return new \Wecamp\Recall\Frontend\Controller\ControllerResolver($app);
});

// Controllers
$app['timeline.controller'] = $app->share(function() use ($app) {
    $timelineController = new \Wecamp\Recall\Frontend\Controller\TimelineController($app['recall']);
    $timelineController->setTemplate($app['twig']);
    return $timelineController;
});

$app['entry.controller'] = $app->share(function() use ($app) {
    $eventController = new \Wecamp\Recall\Frontend\Controller\EntryController($app['recall']);
    $eventController->setTemplate($app['twig']);
    return $eventController;
});

// Views
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => dirname(__FILE__).'/../src/Wecamp/Recall/Frontend/View',
));

// Routing
$app->get('/', 'timeline.controller:listAction');
$app->get('/entry/{contextName}/{entryIdentifier}', 'entry.controller:displayAction');

$app->run();
