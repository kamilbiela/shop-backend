<?php 

$loader = require_once 'vendor/autoload.php';

$app = new \Silex\Application();
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());

// define controllers
$app['controller.product'] = $app->share(function() use ($app) {
    return new \Shop\Controller\Api\ProductController();
});
$app->get('/product/{id}', "controller.product:getOneAction");


return $app;