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
            $table->integer('transaction_id')->comment('From transactions table PK id');
            $table->decimal('amount')->default(0)->comment('currently paid amount');
            $table->dateTime('paid_on')->nullable()->comment('Payment date time');
            $table->string('comments',255)->nullable()->comment('Additional comments that can be entered by the admin');
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
