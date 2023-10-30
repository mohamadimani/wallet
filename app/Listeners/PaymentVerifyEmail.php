<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Events\VerifyPaymentEvent;
use App\Mail\VerifyPayment;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PaymentVerifyEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentVerified $event): void
    {
        $message = __('payment.messages.payment_has_been_verified', ['unique_id' => $event->payment->unique_id]);
        Mail::to('testreceiver@gmail.com')->send((new VerifyPayment($message))->onQueue('VerifyPayment'));
    }
}
