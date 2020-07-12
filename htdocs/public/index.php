<?php

require_once '../config/bootstrap.php';

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

$container = require '../config/container.php';
$app = $container->get(Kernel::class);

$request = Request::createFromGlobals();
$response = $app->handle($request);

$response->send();
