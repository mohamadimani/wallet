<?php

namespace App\Listeners;

use App\Events\StoreTransferEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        $fromUser = DB::table('users')
            ->where('id', $event->transfer->from_account)
            ->lockForUpdate()
            ->first();

        $balace = json_decode($fromUser->balance);
        if (isset($balace->{$event->transfer->currency}) and $balace->{$event->transfer->currency} >= $event->transfer->amount) {
            $balace->{$event->transfer->currency} -= $event->transfer->amount;
        } else {
            $balace = [$event->transfer->currency => $event->transfer->amount];
        }

        $fromUser = DB::table('users')
            ->where('id', $event->transfer->from_account);
        $fromUser->update([
            'balance' => json_encode($balace)
        ]);


        $toUser = DB::table('users')
            ->where('id', $event->transfer->to_account)
            ->lockForUpdate()
            ->first();

        $balace = json_decode($toUser->balance);
        if (isset($balace->{$event->transfer->currency})) {
            $balace->{$event->transfer->currency} += $event->transfer->amount;
        } else {
            $balace = [$event->transfer->currency => $event->transfer->amount];
        }
        $toUser = DB::table('users')
            ->where('id', $event->transfer->to_account);
        $toUserStatus = $toUser->update([
            'balance' => json_encode($balace)
        ]);

        if (!$toUserStatus) {
            DB::rollBack();
        }

        DB::commit();

    }
}
