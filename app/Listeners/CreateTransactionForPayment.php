<?php

namespace App\Listeners;

use App\Events\VerifyPaymentEvent;
use App\Mail\CreateTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CreateTransactionForPayment
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
        $Transaction = Transaction::create([
            'user_id' => $event->payment->user_id,
            'payment_id' => $event->payment->id,
            'amount' => $event->payment->amount,
            'currency' => $event->payment->currency,
            'unique_id' => $event->payment->unique_id,
            'balance' => Transaction::query()->where('user_id', $event->payment->user_id)->sum('amount') + $event->payment->amount
        ]);

        $user = User::findOrFail($event->payment->user_id);
        $user->update([
            'balance' => json_encode([$event->payment->currency => Transaction::query()->where('user_id', $event->payment->user_id)->sum('amount') ])
        ]);

        $message = __('Transaction.messages.Transaction_has_been_created', ['unique_id' => $event->payment->unique_id]);
        Mail::to('testreceiver@gmail.com')->send((new CreateTransaction($message))->onQueue('CreatePayment'));
    }
}
