<?php

namespace App\Listeners;

use App\Events\StorePaymentEvent;
use App\Mail\StorePayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class StorePaymentEmail
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
    public function handle(StorePaymentEvent $event): void
    {
        $message = __('payment.messages.payment_has_been_created', ['unique_id' => $event->payment->unique_id]);
        Mail::to('testreceiver@gmail.com')->send((new StorePayment($message))->onQueue('storePayment'));
    }
}
