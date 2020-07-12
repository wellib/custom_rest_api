<?php

namespace App\Controller;

use App\Http\AppJsonResponse;
use App\Service\ProductService;
use Exception;

class InitController
{

    /**
     * @var \App\Service\ProductService
     */
    private $productService;

    /**
     * InitController constructor.
     *
     * @param \App\Service\ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return \App\Http\AppJsonResponse
     * @throws \Exception
     */
    public function init(): AppJsonResponse
    {

        try {
            $products = $this->productService->generate();
        } catch (Exception $e) {
            throw new Exception('Error Initialize');
        }

        return new AppJsonResponse($products);
    }
}
