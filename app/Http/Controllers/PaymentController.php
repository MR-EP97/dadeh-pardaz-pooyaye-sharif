<?php

namespace App\Http\Controllers;

use App\Enums\Payment\PaymentStatus;
use App\Enums\SubmitRequestStatus;
use App\Jobs\PaymentJob;
use App\Models\SubmitRequest;
use App\Services\PaymentServices\PaymentGatewayFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    /**
     * @throws Exception
     */
    public function __invoke()
    {
        $submitRequests = SubmitRequest::where('status', SubmitRequestStatus::APPROVED)->get();

        foreach ($submitRequests as $submitRequest) {
            switch ($this->getBankCode((string)$submitRequest->iban)) {
                case '11':
                    $gateway = PaymentGatewayFactory::create('bank_one');
                    break;
                case '22':
                    $gateway = PaymentGatewayFactory::create('bank_two');
                    break;
                case '33':
                    $gateway = PaymentGatewayFactory::create('bank_three');
                    break;
                default:
                    $submitRequest->update(['status' => SubmitRequestStatus::INVALID_ACCOUNT]);
                    $submitRequest->save();
                    Log::channel('submit-request')->error('Invalid SHABA number - ' . json_encode($submitRequest->toArray()));
                    continue 2;
            }
            PaymentJob::dispatch($submitRequest, $gateway);
        }
    }

    /**
     * @param string $iban
     * @return string
     */
    private function getBankCode(string $iban): string
    {
        return substr($iban, 0, 2);
    }
}
