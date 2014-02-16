<?php

namespace Shop;

use Shop\Lib\Serializer\CollectionSerializer;

$loader = require_once 'vendor/autoload.php';

// define silex dependencies
$app = new \Silex\Application();
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());

// load config
$app->register(new \Igorw\Silex\ConfigServiceProvider(__DIR__."/config/common.yml"));
$app->register(new \Igorw\Silex\ConfigServiceProvider(__DIR__."/config/" . (getenv('APP_ENV') ?: 'prod') . ".yml"));

// set config variables
date_default_timezone_set($app['config']['timezone']);

if($app['config']['disable_exception_handler']) {
    $app['exception_handler']->disable();
}

// configure doctrine
// @todo cache! http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/advanced-configuration.html
$app['db.em'] = $app->share(function ($app) {
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/src/model'), $app['debug']);
    return \Doctrine\ORM\EntityManager::create($app['config']['database'], $config);
});

// define controllers
$app['controller.product'] = $app->share(function() use ($app) {
    return new \Shop\Controller\Api\ProductController($app['db.em'], new CollectionSerializer());
});

$app->get('/product/{uid}', "controller.product:getOneAction");
$app->get('/product', 'controller.product:getAction');
$app->post('/product', 'controller.product:addAction');
$app->put('/product/{uid}', 'controller.product:updateAction');

return $app;