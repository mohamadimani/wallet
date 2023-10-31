<?php

namespace App\Listeners;

use App\Enums\PaymentStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActionsApproval
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
    public function handle(object $event): void
    {
        $byModel = $eventType = $message = '';
        $className = class_basename($event);
        $byModel = auth()->user();

        if ($className == 'PaymentRejected') {
            $onModel = $event->payment;
            $eventType = PaymentStatusEnum::Rejected->value;
            $message = '';
        } else if ($className == 'PaymentVerified') {
            $onModel = $event->payment;
            $eventType = PaymentStatusEnum::Verified->value;
            $message = '';
        }

        activity()
            ->causedBy($byModel)
            ->performedOn($onModel)
            ->event($eventType)
            ->log($message);
    }
}
