<?php

namespace App\Services\PaymentServices;

use App\Enums\Payment\BankUrl;
use App\Enums\Payment\PaymentStatus;
use App\Enums\SubmitRequestStatus;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\SubmitRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\throwException;

class BankOnePaymentGateway implements PaymentGatewayInterface
{


    public function __construct()
    {
    }

    /**
     */
    public function initiatePayment(int $amount, string $recipientAccount): array|bool
    {
        $response = [
            'code' => random_int(10 ** 5, 10 ** 6 - 1),
            'status' => 'success',
        ];
        return ['status' => 'success',
            'data' => $response,];
//
//        $headers = [
//            'Authorization' => 'Bearer ' . config('payment.token_bank_1'),
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//        ];
//
//        $params = [
//            'amount' => $amount,
//            'organization_account' => config('payment.main_organization_account'),
//            'recipient_account' => $recipientAccount,
//            'transaction_id' => uniqid('', true)
//        ];
//        try {
//            return (array)Http::withHeaders($headers)->post(
//                BankUrl::URL1,
//                $params,
//            );
//        } catch (\Exception $e) {
//            if ($e instanceof ConnectionException) {
//                //log
//            } else {
//                //log
//            }
//            return false;
//        }
    }

    public function handlePaymentResponse(array $response): bool
    {
        return $response['status'] === 'success';
    }

    public function savePaymentRecord(array $paymentData, SubmitRequest $submitRequest): void
    {
        $submitRequest->update(['status' => SubmitRequestStatus::CLOSED]);

        if ($this->handlePaymentResponse($paymentData)) {
            $submitRequest->payment()->create([
                'code' => $paymentData['code'],
                'status' => PaymentStatus::SUCCESS,
                'getaway' => class_basename(__CLASS__),
            ]);
        } else {
            $submitRequest->payment()->create([
                'code' => $paymentData['code'],
                'status' => PaymentStatus::FAILED,
                'getaway' => class_basename(__CLASS__),
            ]);
        }
        $submitRequest->save();

    }


}
