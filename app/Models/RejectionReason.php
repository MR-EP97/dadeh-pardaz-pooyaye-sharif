<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RejectionReason extends Model
{
    protected $fillable = [
        'description',
        'submit_request_id',
    ];

    public function submitRequest(): BelongsTo
    {
        return $this->belongsTo(SubmitRequest::class);
    }
}
