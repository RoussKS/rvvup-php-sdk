<?php

declare(strict_types=1);

namespace Rvvup\Sdk\Tests\Unit\Inputs;

use PHPUnit\Framework\TestCase;
use Rvvup\Sdk\Inputs\RefundCreateInput;
use Rvvup\Sdk\Tests\HelperTrait;

class RefundCreateInputTest extends TestCase
{
    use HelperTrait;

    /**
     * @throws \Exception
     */
    public function test_order_id_argument_is_set(): void
    {
        $orderId = $this->getRandomString();
        $input = new RefundCreateInput($orderId, '00', 'GBP', 'KEY', 'Reason');
        $this->assertEquals($orderId, $input->getOrderId());
    }

    /**
     * @throws \Exception
     */
    public function test_amount_argument_is_set(): void
    {
        $amount = $this->getRandomNumber();
        $input = new RefundCreateInput('ORDASSA', (string) $amount, 'GBP', 'KEY', 'Reason');
        $this->assertEquals((string) $amount, $input->getAmount());
    }

    /**
     * @throws \Exception
     */
    public function test_currency_argument_is_set(): void
    {
        $currency = $this->getRandomString(3);
        $input = new RefundCreateInput('ORDASSA', '000', $currency, 'KEY', 'Reason');
        $this->assertEquals($currency, $input->getCurrency());
    }

    /**
     * @throws \Exception
     */
    public function test_idempotency_key_argument_is_set(): void
    {
        $idempotencyKey = $this->getRandomString();
        $input = new RefundCreateInput('ORDASSA', '000', 'GBP', $idempotencyKey, 'Reason');
        $this->assertEquals($idempotencyKey, $input->getIdempotencyKey());
    }

    /**
     * @throws \Exception
     */
    public function test_reason_argument_is_set(): void
    {
        $reason = $this->getRandomString();
        $input = new RefundCreateInput('ORDASSA', '000', 'GBP', 'KEY', $reason);
        $this->assertEquals($reason, $input->getReason());
    }
}
