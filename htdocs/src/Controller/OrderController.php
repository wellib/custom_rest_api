<?php

namespace App\Controller;

use App\Http\AppJsonResponse;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderController extends BaseController
{

    /**
     * @var \App\Service\OrderService
     */
    private $orderService;

    /**
     * OrderController constructor.
     *
     * @param \App\Service\OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Http\AppJsonResponse
     */
    public function index(Request $request): AppJsonResponse
    {

        $data = $this->getRequest($request);
        if (empty($data['items']) || !is_array($data['items']) || !count(
                $data['items']
            )) {
            throw new BadRequestHttpException('Bad Request');
        }

        $order = $this->orderService->create($data['items']);

        return new AppJsonResponse($order);

    }
}
