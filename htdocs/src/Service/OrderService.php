<?php

namespace App\Service;


use App\Entity\Order;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderService
{

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \App\Repository\ProductRepository
     */
    private $productRepository;

    /**
     * OrderService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \App\Repository\ProductRepository $productRepository
     */
    public function __construct(
        EntityManagerInterface $em,
        ProductRepository $productRepository
    ) {
        $this->em = $em;
        $this->productRepository = $productRepository;
    }

    /**
     * @param array $items
     *
     * @return \App\Entity\Order
     */
    public function create(array $items): Order
    {
        $products = [];
        $total = 0;
        foreach ($items as $item) {
            if (!is_int($item) || $item <= 0) {
                continue;
            }
            $product = $this->productRepository->find($item);
            if ($product) {
                $total += $product->getPrice();
                $products[] = $product;
            }
        }
        if (!count($products)) {
            throw new BadRequestHttpException('Bad Request');
        }

        $order = new Order();
        $order->setProducts($products);
        $order->setTotal($total);
        // default user
        $order->setUserId(1);

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

}
