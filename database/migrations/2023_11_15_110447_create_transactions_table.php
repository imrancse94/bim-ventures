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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id',100)->comment('transaction unique key for every transaction');
            $table->integer('user_id')->default(0)->comment('From users table pk id, the customer who will pay the given amount');
            $table->decimal('amount')->default(0)->comment('transaction amount');
            $table->decimal('vat')->default(0)->comment('Percentage amount of vat');
            $table->tinyInteger('is_vat_included')->default(0)->comment('1 = included, 0 = not included');
            $table->enum('transaction_status',[1,2,3])->default(1)->comment('1 = outstanding, 2 = paid, 3 = Overdue');
            $table->date('due_date')->nullable()->comment('Payment due date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
