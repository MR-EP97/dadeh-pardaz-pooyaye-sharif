<?php

namespace App\Enums;

//for submit model
enum SubmitRequestStatus
{

    public const PENDING = 'pending';
    // The user has submitted a request.

    public const CLOSED = 'closed';
    // The request has been closed (either the payment was successful or unsuccessful).

    public const APPROVED = 'approved';
    // The request has been approved.

    public const Rejected = 'rejected';
    // The request has been rejected.

    public const INVALID_ACCOUNT = 'invalid_account';
    // The SHABA number was invalid and the gateway was not accessed.

    public const FAILED = 'failed';
    // Encountered a gateway connection error.


}
