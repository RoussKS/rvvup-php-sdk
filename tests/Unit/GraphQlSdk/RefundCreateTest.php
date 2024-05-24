<?php

declare(strict_types=1);

namespace Rvvup\Sdk\Tests\Unit\GraphQlSdk;

use Exception;
use Rvvup\Sdk\Curl;
use Rvvup\Sdk\Exceptions\NetworkException;
use Rvvup\Sdk\Factories\Inputs\RefundCreateInputFactory;
use Rvvup\Sdk\Response;

class RefundCreateTest extends AbstractGraphQlSdkTestCase
{
    private $refundCreateData = [
        'data' => [
            'refundCreate' => [
                'id' => 'REXXXXXXX',
                'amount' => [
                    'amount' => 10.00,
                    'currency' => 'GBP'
                ],
                'status' => 'SUCCESSFUL'
            ]
        ]
    ];

    /**
     * @throws \Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function test_successful_refund_call(): void
    {
        $curlStub = $this->createStub(Curl::class);

        $graphQlSdk = $this->createGraphQlSdk($curlStub);

        $response = new Response(200, json_encode($this->refundCreateData, JSON_THROW_ON_ERROR), []);

        $curlStub->method('request')->willReturn($response);

        $inputFactory = new RefundCreateInputFactory();

        $this->assertIsArray($graphQlSdk->refundCreate($inputFactory->create(
            'ORXXXX',
            '10.00',
            'GBP',
            'KEY',
            'RANDOM REASON'
        )));
    }

    /**
     * @throws \Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function test_false_on_empty_response(): void
    {
        $curlStub = $this->createStub(Curl::class);

        $graphQlSdk = $this->createGraphQlSdk($curlStub);

        $response = new Response(200, json_encode($this->refundCreateData['data'], JSON_THROW_ON_ERROR), []);

        $curlStub->method('request')->willReturn($response);

        $inputFactory = new RefundCreateInputFactory();

        $this->assertFalse($graphQlSdk->refundCreate($inputFactory->create(
            'ORXXXX',
            '10.00',
            'GBP',
            'KEY',
            'RANDOM REASON'
        )));
    }

    /**
     * @throws \Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function test_exception_on_non_2xx_response_code(): void
    {
        $this->expectException(Exception::class);

        $curlStub = $this->createStub(Curl::class);

        $graphQlSdk = $this->createGraphQlSdk($curlStub);

        $response = new Response(400, json_encode($this->refundCreateData, JSON_THROW_ON_ERROR), []);

        $curlStub->method('request')->willReturn($response);

        $inputFactory = new RefundCreateInputFactory();

        $this->assertFalse($graphQlSdk->refundCreate($inputFactory->create(
            'ORXXXX',
            '10.00',
            'GBP',
            'KEY',
            'RANDOM REASON'
        )));
    }

    /**
     * @throws \Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function test_network_exception_on_5xx_response_code(): void
    {
        $this->expectException(NetworkException::class);

        $curlStub = $this->createStub(Curl::class);

        $graphQlSdk = $this->createGraphQlSdk($curlStub);

        $response = new Response(random_int(500, 599), json_encode($this->refundCreateData, JSON_THROW_ON_ERROR), []);

        $curlStub->method('request')->willReturn($response);

        $inputFactory = new RefundCreateInputFactory();

        $this->assertFalse($graphQlSdk->refundCreate($inputFactory->create(
            'ORXXXX',
            '10.00',
            'GBP',
            'KEY',
            'RANDOM REASON'
        )));
    }
}
