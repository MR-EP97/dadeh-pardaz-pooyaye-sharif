<?php

namespace App\Services\PaymentServices;

use App\Interfaces\PaymentGatewayInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\SubmitRequest;

class BankThreePaymentGateway implements PaymentGatewayInterface
{

    public function __construct(protected Client $client = new Client())
    {
    }

    /**
     */
    public function initiatePayment(int $amount, string $recipientAccount): array|bool
    {
    }

    public function handlePaymentResponse(array $response): bool
    {
    }

    public function savePaymentRecord(array $paymentData, SubmitRequest $submitRequest): void
    {
    }

}
