<?php

namespace App\Providers;

use App\Events\PaymentRejected;
use App\Events\RejectPaymentEvent;
use App\Events\PaymentStored;
use App\Events\PaymentVerified;
use App\Events\StoreTransferEvent;
use App\Listeners\CreateTransactionForPayment;
use App\Listeners\PaymentRejectEmail;
use App\Listeners\PaymentStoreEmail;
use App\Listeners\PaymentVerifyEmail;
use App\Listeners\RejectPaymentEmail;
use App\Listeners\StorePaymentEmail;
use App\Listeners\TransferCredit;
use App\Listeners\VerifyPaymentEmail;
use App\Mail\CreateTransaction;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PaymentRejected::class => [
            PaymentRejectEmail::class,
        ],
        PaymentStored::class => [
            PaymentStoreEmail::class,
        ],
        PaymentVerified::class => [
            PaymentVerifyEmail::class,
        ],
        TransactionStore::class => [
            TransferCredit::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
