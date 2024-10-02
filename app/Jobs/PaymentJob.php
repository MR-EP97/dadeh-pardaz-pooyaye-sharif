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
            if ($paymentResponse = $this->gateway->initiatePayment($this->submitRequest['amount'], $this->submitRequest['iban'])) {
                // Connected to the gateway, received a response, and the transaction may or may not be successful.

                $this->gateway->savePaymentRecord($paymentResponse, $this->submitRequest);
            } else {
                // Failed to connect to the gateway.

                $this->submitRequest->update(['status' => SubmitRequestStatus::FAILED]);
                $this->submitRequest->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }
    }
}
