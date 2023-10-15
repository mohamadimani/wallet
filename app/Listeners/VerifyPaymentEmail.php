<?php

namespace App\Listeners;

use App\Events\VerifyPaymentEvent;
use App\Mail\VerifyPayment;
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
    }
}
