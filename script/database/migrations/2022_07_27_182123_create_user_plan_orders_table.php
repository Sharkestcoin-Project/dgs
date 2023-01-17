<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plan_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('invoice_no');
            $table->string('trx')->nullable();
            $table->double('amount')->nullable();
            $table->string('period')->nullable();
            $table->boolean('is_open')->default(0);
            $table->timestamp('subscription_expire_at')->nullable();
            $table->foreignId('subscriber_id')->constrained('user_plan_subscribers')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('gateway_id')->constrained('gateways')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_plan_orders');
    }
};
