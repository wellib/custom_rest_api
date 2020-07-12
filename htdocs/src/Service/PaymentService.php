<?php

namespace App\Service;


use App\Entity\Order;
use App\Entity\Payment;
use App\Repository\OrderRepository;
use App\Service\PaymentProvider\PaymentProviderService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaymentService
{

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \App\Repository\OrderRepository
     */
    private $orderRepository;

    /**
     * @var \App\Service\PaymentProvider\PaymentProviderService
     */
    private $paymentProviderService;

    /**
     * OrderService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \App\Repository\OrderRepository $orderRepository
     * @param \App\Service\PaymentProvider\PaymentProviderService $paymentProviderService
     */
    public function __construct(
        EntityManagerInterface $em,
        OrderRepository $orderRepository,
        PaymentProviderService $paymentProviderService
    ) {
        $this->em = $em;
        $this->orderRepository = $orderRepository;
        $this->paymentProviderService = $paymentProviderService;
    }

    /**
     * @param int $orderId
     * @param int $amount
     *
     * @return \App\Entity\Order
     * @throws \Exception
     */
    public function create(int $orderId, int $amount): Order
    {

        /** @var Order $order */
        $order = $this->orderRepository->find($orderId);

        if (!$order) {
            throw new BadRequestHttpException('Order Not Found');
        }

        if ($order->getStatus() !== Order::ORDER_STATUS_NEW) {
            throw new BadRequestHttpException('Order Already Paid');
        }
        if ($order->getTotal() !== $amount) {
            throw new BadRequestHttpException('Bad Amount');
        }

        try {
            $this->paymentProviderService->process();
        } catch (GuzzleException $e) {
            throw new BadRequestHttpException('Payment Fail');
        }

        // Статус заказа - Оплачен
        $order->setStatus(Order::ORDER_STATUS_PAID);
        $this->em->persist($order);
        $this->em->flush();

        // Запись платежа
        $payment = new Payment();
        $payment->setOrderId($orderId);
        $payment->setAmount($amount);
        $this->em->persist($payment);
        $this->em->flush();

        return $order;
    }

}
