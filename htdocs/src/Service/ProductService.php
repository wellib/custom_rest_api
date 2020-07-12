<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ProductService
 *
 * @package App\Service
 */
class ProductService
{

    /**
     *
     */
    public const PRODUCT_SERVICE_GENERATE_COUNT = 20;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \App\Repository\ProductRepository
     */
    private $productRepository;

    /**
     * ProductService constructor.
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
     * @return array
     * @throws \Exception
     * @throws \Exception
     */
    public function generate(): array
    {

        $count = $this->productRepository->count([]);
        if (!$count) {
            for ($i = 0; $i < self::PRODUCT_SERVICE_GENERATE_COUNT; $i++) {
                $product = new Product();
                $product->setName('Product #'.random_int(1000, 10000));
                $product->setPrice(random_int(100, 100000));
                $this->em->persist($product);
            }
            $this->em->flush();
        }

        return $this->productRepository->findAll();

    }
}
