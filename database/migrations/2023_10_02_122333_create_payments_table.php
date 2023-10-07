<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->double('amount');
            $table->string('priceunit');
            $table->string('attach_file')->nullable();
            $table->integer('payment_at')->nullable();
            $table->string('status')->default('pending');
            $table->integer('rejected_at')->nullable();
            $table->integer('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
