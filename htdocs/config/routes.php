<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use App\Controller\InitController;
use App\Controller\OrderController;
use App\Controller\PaymentController;

$routes = new RouteCollection();

$routes->add(
    'init',
    (new Route(
        '/init', ['_controller' => [InitController::class, 'init']]
    ))->setMethods('POST')
);

$routes->add(
    'order',
    (new Route(
        '/order', ['_controller' => [OrderController::class, 'index']]
    ))->setMethods('POST')
);

$routes->add(
    'payment',
    (new Route(
        '/payment/{orderId}', ['_controller' => [PaymentController::class, 'index']]
    ))->setMethods('POST')
);

return $routes;
