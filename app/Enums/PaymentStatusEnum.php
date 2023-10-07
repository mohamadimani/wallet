<?php

namespace App\Enums;

enum PaymentStatusEnum:string{
    case Pending = 'pending';
    case Verified = 'verified';
    case Rejected = 'rejected';
} 
