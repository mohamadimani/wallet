<?php

namespace App\Jobs;

use App\Mail\RejectedPayment;
use App\Models\payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RejectPaymentEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Payment $payment, public $message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw($this->message, function ($message) {
            $message->from('mohamadimahdi0406@gmail.com', 'mani');
            $message->sender('mohamadimahdi0406@gmail.com', 'mani');
            $message->to('mahdieightt@gmail.com', 'Mahdi Amereh');
            $message->subject('Test Mail');
        });
    }
}
