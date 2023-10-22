<?php

namespace App\Listeners;

use App\Events\StoreTransferEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransferCredit
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
    public function handle(StoreTransferEvent $event): void
    {
        User::where('id', $event->transfer->from_account)->decrement('balance', $event->transfer->amount);
        User::where('id', $event->transfer->to_account)->increment('balance', $event->transfer->amount);
    }
}
