<?php

namespace App;

use App\Http\AppJsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Throwable;

class Kernel extends HttpKernel
{

    public function __construct(
        EventDispatcherInterface $dispatcher,
        ControllerResolverInterface $resolver,
        RequestStack $requestStack = null,
        ArgumentResolverInterface $argumentResolver = null
    ) {
        parent::__construct(
            $dispatcher,
            $resolver,
            $requestStack,
            $argumentResolver
        );
    }

    public function handle(
        Request $request,
        int $type = HttpKernelInterface::MASTER_REQUEST,
        bool $catch = true
    ) {

        try {

            return parent::handle(
                $request,
                $type,
                $catch
            );

        } catch (Throwable $throwable) {

            // Подмена текста сообщений об ошибках
            $statusCode = 500;
            $message = 'Internal Error';
            if ($throwable instanceof HttpException) {
                $statusCode = $throwable->getStatusCode();
                $message = $throwable->getMessage();
            }

            return new AppJsonResponse(
                $message,
                AppJsonResponse::APP_JSON_RESPONSE_ERROR,
                $statusCode
            );

        }

    }

}
