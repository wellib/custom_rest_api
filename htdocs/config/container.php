<?php

use App\Controller\InitController;
use App\Controller\OrderController;
use App\Controller\PaymentController;
use App\Kernel;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Payment;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\PaymentRepository;
use App\Service\ProductService;
use App\Service\OrderService;
use App\Service\PaymentService;
use App\Service\PaymentProvider\PaymentProviderService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher\EventDispatcher;
use \Symfony\Component\HttpFoundation\RequestStack;

$em = require (__DIR__).'/doctrine.php';

$containerBuilder = new ContainerBuilder();

$containerBuilder->set('em', $em);

// Register Product Services
$containerBuilder->register(InitController::class, InitController::class)
    ->setArguments([new Reference(ProductService::class)]);
$containerBuilder->register(ProductRepository::class, ProductRepository::class)
    ->setArguments([$em, $em->getClassMetadata(Product::class)]);
$containerBuilder->register(ProductService::class, ProductService::class)
    ->setArguments([$em, new Reference(ProductRepository::class)]);

// Register Order Services
$containerBuilder->register(OrderController::class, OrderController::class)
    ->setArguments([new Reference(OrderService::class)]);
$containerBuilder->register(OrderRepository::class, OrderRepository::class)
    ->setArguments([$em, $em->getClassMetadata(Order::class)]);
$containerBuilder->register(OrderService::class, OrderService::class)
    ->setArguments([$em, new Reference(ProductRepository::class)]);

// Register Payment Services
$containerBuilder->register(PaymentController::class, PaymentController::class)
    ->setArguments([new Reference(PaymentService::class)]);
$containerBuilder->register(PaymentRepository::class, PaymentRepository::class)
    ->setArguments([$em, $em->getClassMetadata(Payment::class)]);
$containerBuilder->register(PaymentProviderService::class, PaymentProviderService::class);
$containerBuilder->register(PaymentService::class, PaymentService::class)
    ->setArguments(
        [
            $em,
            new Reference(OrderRepository::class),
            new Reference(PaymentProviderService::class),
        ]
    );

// Route Config
$routes = require (__DIR__).'/routes.php';
$matcher = new Routing\Matcher\UrlMatcher(
    $routes, new Routing\RequestContext()
);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(
    new HttpKernel\EventListener\RouterListener($matcher, new RequestStack())
);

$controllerResolver = new HttpKernel\Controller\ContainerControllerResolver(
    $containerBuilder
);
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

// Kernel
$containerBuilder->register(Kernel::class, Kernel::class)
    ->setArguments(
        [
            $dispatcher,
            $controllerResolver,
            new RequestStack(),
            $argumentResolver,
        ]
    );

return $containerBuilder;
