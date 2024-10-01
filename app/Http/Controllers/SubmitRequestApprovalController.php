<?php

namespace App\Http\Controllers;

use App\Http\Requests\DecisionSubmitRequest;
use App\Models\RejectionReason;
use App\Models\SubmitRequest;
use App\Models\User;
use App\Notifications\RequestRejectedNotification;
use Illuminate\Http\Request;

class SubmitRequestApprovalController extends Controller
{
    public function review()
    {
        return SubmitRequest::with('user')->paginate(10);
    }

    public function decision(DecisionSubmitRequest $request)
    {
        foreach ($request->input('requests_decision') as $req) {
            $submitRequests = SubmitRequest::query()->where('id', $req['id'])->first();
            $submitRequests->update([
                'status' => $req['status'],
                'updated_at' => now()
            ]);
//            approved,rejected
            if ($req['status'] === 'rejected') {
                $submitRequests->rejectionReason()->create([
                    'description' => $req['reason']
                ]);
                $mail['submit_id'] = $req['id'];
                $mail['description'] = $req['reason'];
                $submitRequests->user->notify(new RequestRejectedNotification($mail));
            }


        }
    }

    public function showRejectDescription($id)
    {
        return SubmitRequest::query()->find($id)->rejectionReason->description;
    }
}
