<?php

namespace App\Listeners;

use App\Events\PaymentRejected;
use App\Events\RejectPaymentEvent;
use App\Mail\RejectedPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PaymentRejectEmail
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
    public function handle(PaymentRejected $event): void
    {
        $message = __('payment.messages.payment.messages.payment_has_been_rejected', ['unique_id' => $event->payment->unique_id]);
        Mail::to('testreceiver@gmail.com')->send((new RejectedPayment($message))->onQueue('rejectPayment'));
    }
}
