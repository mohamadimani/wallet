<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;


class PaymentException extends Exception
{

    public function report()
    {
        return Log::info(__('payment.errors.try_again'));
    }

    public function render($request)
    {
        // return Log::info(__('payment.errors.try_again'));
    }
}
