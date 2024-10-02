<?php

namespace App\Http\Controllers;

use App\Enums\SubmitRequestStatus;
use App\Http\Requests\DecisionSubmitRequest;
use App\Http\Resources\SubmitRequestCollection;
use App\Models\SubmitRequest;
use App\Notifications\RequestRejectedNotification;
use App\Traits\JsonResponseTraits;
use Illuminate\Http\JsonResponse;


class SubmitRequestApprovalController extends Controller
{
    use JsonResponseTraits;

    public function review(): JsonResponse
    {
        return $this->success(
            'Show all submit requests successfully',
            array(new SubmitRequestCollection(SubmitRequest::paginate(10)))
        );
    }

    public function decision(DecisionSubmitRequest $request): JsonResponse
    {
        foreach ($request->input('requests_decision') as $req) {
            $submitRequests = SubmitRequest::query()->where('id', $req['id'])->first();
            $submitRequests->update([
                'status' => $req['status'],
                'updated_at' => now()
            ]);
            if ($req['status'] === SubmitRequestStatus::Rejected) {
                $submitRequests->rejectionReason()->create([
                    'description' => $req['reason']
                ]);
                $mail['submit_id'] = $req['id'];
                $mail['description'] = $req['reason'];
                $submitRequests->user->notify(new RequestRejectedNotification($mail));
            }
        }

        return $this->success(
            'The changes have been successfully applied'
        );
    }

    public function showRejectDescription($id): JsonResponse
    {
        return $this->success(
            'Show rejected description',
            ['description' => SubmitRequest::query()->find($id)->rejectionReason->description]
        );
    }
}
