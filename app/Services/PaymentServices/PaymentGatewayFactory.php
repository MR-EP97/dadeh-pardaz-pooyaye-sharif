<?php

namespace App\Services\PaymentServices;


class PaymentGatewayFactory
{
    /**
     * @throws \Exception
     */
    public static function create(string $bankName): BankOnePaymentGateway|BankThreePaymentGateway|BankTwoPaymentGateway
    {
        return match ($bankName) {
            'bank_one' => new BankOnePaymentGateway(),
            'bank_two' => new BankTwoPaymentGateway(),
            'bank_three' => new BankThreePaymentGateway(),
            default => throw new \Exception("Invalid bank name"),
        };
    }
}
