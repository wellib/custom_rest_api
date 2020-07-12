<?php

namespace App\Service\PaymentProvider;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaymentProviderService
{

    public const PAYMENT_PROVIDER_URL = 'http://ya.ru';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * PaymentProviderService constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function process(): void
    {
        try {

            $this->client->request('GET', self::PAYMENT_PROVIDER_URL);

        } catch (ClientException $exception) {

            throw new BadRequestHttpException('Payment Fail');

        }
    }
}
