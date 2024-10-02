<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class SubmitRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'expense' => $this->expense,
            'amount' => $this->amount,
            'iban' => $this->iban,
            'description' => $this->description,
            'attachment' => $this->attachment,
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
            'national_id' => $this->user->national_id,
        ];

    }
}
