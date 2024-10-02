<?php

namespace App\Interfaces;

use App\Models\SubmitRequest;

interface PaymentGatewayInterface
{
    /**
     *
     * @param int $amount
     * @param string $recipientAccount
     * @return array
     */
    public function initiatePayment(int $amount, string $recipientAccount): array|bool;

    /**
     *
     * @param array $response
     * @return bool
     */
    public function handlePaymentResponse(array $response): bool;

    /**
     *
     * @param array $paymentData
     * @return void
     */
    public function savePaymentRecord(array $paymentData, SubmitRequest $submitRequest): void;
}
