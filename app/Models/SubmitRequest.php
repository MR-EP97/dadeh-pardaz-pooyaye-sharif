<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SubmitRequest extends Model
{

    protected $fillable = [
        'expense',
        'description',
        'amount',
        'attachment',
        'iban',
        'status',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rejectionReason(): HasOne
    {
        return $this->hasOne(RejectionReason::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'submit_request_id', 'id');
    }

    /**
     * Mask the IBAN number except for the last four digits.
     *
     * @return string
     */
    public function maskedIban(): string
    {
        $iban = $this->iban;
        if (strlen($iban) > 4) {
            return str_repeat('*', strlen($iban) - 4) . substr($iban, -4);
        }
        return $iban;
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        $array['iban'] = $this->maskedIban();

        return $array;
    }
}
