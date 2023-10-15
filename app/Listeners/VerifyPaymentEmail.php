<?php

namespace App\Listeners;

use App\Events\VerifyPaymentEvent;
use App\Mail\VerifyPayment;
use App\Models\transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class VerifyPaymentEmail
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
    public function handle(VerifyPaymentEvent $event): void
    {
        $message = 'Payment with ' . $event->payment->unique_id . ' key has been Verified';
        Mail::to('testreceiver@gmail.com')->send((new VerifyPayment($message))->onQueue('VerifyPayment'));

        transaction::created([
            'user_id' => $event->payment->user_id,
            'payment_id' => $event->payment->id,
            'amount' => $event->payment->amount,
            'currency' => $event->payment->currency,
            'unique_id' => $event->payment->unique_id,
            // 'balance' => $event->payment->balance
        ]);
    }
}
