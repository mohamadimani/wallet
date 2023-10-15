<?php

namespace App\Listeners;

use App\Events\RejectPaymentEvent;
use App\Mail\RejectedPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RejectPaymentEmail
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
    public function handle(RejectPaymentEvent $event): void
    {
        $message = 'payment with ' . $event->payment->unique_id . ' key has been rejected';
        Mail::to('testreceiver@gmail.com')->send((new RejectedPayment($message))->onQueue('rejectPayment'));
    }
}
