<?php

namespace App\Services\PaymentServices;

use App\Enums\Payment\BankUrl;
use App\Enums\Payment\PaymentStatus;
use App\Enums\SubmitRequestStatus;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Payment;
use App\Models\SubmitRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // for testing
        $response = [
            'code' => random_int(10 ** 5, 10 ** 6 - 1),
            'status' => 'success',
        ];
        return ['status' => 'success',
            'data' => $response,];
        // for testing


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
//        Log::channel('payment')->error('Connection to the' . class_basename(__CLASS__) . ' gateway was not possible .');
//            } else {
//        Log::channel('payment')->error('The request to < ' . class_basename(__CLASS__) . ' > has failed. Message: ' . $e->getMessage);

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

            $payment = Payment::query()->create([
                'code' => $paymentData['data']['code'],
                'status' => PaymentStatus::SUCCESS,
                'getaway' => class_basename(__CLASS__),
                'submit_request_id' => $submitRequest->id
            ]);
            Log::channel('payment')->info('The transaction was completed successfully' . json_encode($payment, JSON_THROW_ON_ERROR));


        } else {
            $payment = Payment::query()->create([
                'code' => $paymentData['data']['code'],
                'status' => PaymentStatus::FAILED,
                'getaway' => class_basename(__CLASS__),
                'submit_request_id' => $submitRequest->id
            ]);
            Log::channel('payment')->error('The transaction failed.' . json_encode($payment, JSON_THROW_ON_ERROR));

        }

    }


}
