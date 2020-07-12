<?php

namespace App\Controller;

use App\Http\AppJsonResponse;
use App\Service\PaymentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaymentController extends BaseController
{

    /**
     * @var \App\Service\PaymentService
     */
    private $paymentService;

    /**
     * PaymentController constructor.
     *
     * @param \App\Service\PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $orderId
     *
     * @return \App\Http\AppJsonResponse
     * @throws \Exception
     */
    public function index(Request $request, int $orderId): AppJsonResponse
    {

        $data = $this->getRequest($request);
        if (empty($data['amount']) || !($data['amount'] > 0)) {
            throw new BadRequestHttpException('Bad Request');
        }

        $order = $this->paymentService->create($orderId, $data['amount']);

        return new AppJsonResponse($order);

    }
}
