<?php

namespace App\Console\Commands;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeletePendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-pending-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Payment::where('status', PaymentStatusEnum::Pending->value)
        //     ->where('created_at', Carbon::now()->subHours(24))
        //     ->chunk(10 , function());
    }

    // public function handles()
    // {
    //     Payment::where([
    //         ['status', $this->argument('status')],
    //         ['created_at', '<', Carbon::now()->subHours(config('settings.payment.delete_payment_after_hours'))]
    //     ])
    //         ->chunk(config('settings.payment.delete_list_of_payment_number'), function ($payments) {
    //             DeleteListOfPaymentJob::dispatch($payments->pluck('id')->toArray());
    //         });
    // }
}
