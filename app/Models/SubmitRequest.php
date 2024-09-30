<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense',
        'description',
        'amount',
        'attachment',
        'iban',
        'status',
        'user_id',
    ];

//    public function setUserIdAttribute($value)
//    {
//        dd($value);
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
