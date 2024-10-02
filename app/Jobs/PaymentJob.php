<?php

namespace App\Jobs;

use App\Enums\Payment\PaymentStatus;
use App\Enums\SubmitRequestStatus;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\SubmitRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected SubmitRequest           $submitRequest,
        protected PaymentGatewayInterface $gateway)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            DB::beginTransaction();
            Log::channel('payment')->info('Request by submitID : ' . $this->submitRequest->id . ' is starting a transaction on gateway ' . class_basename($this->gateway));

            if ($paymentResponse = $this->gateway->initiatePayment($this->submitRequest['amount'], $this->submitRequest['iban'])) {
                // Connected to the gateway, received a response, and the transaction may or may not be successful.

                Log::channel('payment')->info('Gateway ' . class_basename($this->gateway) . ' responded successfully.');
                $this->gateway->savePaymentRecord($paymentResponse, $this->submitRequest);
                Log::channel('payment')->info('Payment information has been stored in the database.');
            } else {
                // Failed to connect to the gateway.
                Log::channel('submit-request')->error('Request has failed . ID = ' . $this->submitRequest->id);
                $this->submitRequest->update(['status' => SubmitRequestStatus::FAILED]);
                $this->submitRequest->save();
            }
            DB::commit();
            Log::channel('payment')->info('The payment process has been completed.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('submit-request')->alert('Unknown exception: ' . $e->getMessage());
        }
    }
}
