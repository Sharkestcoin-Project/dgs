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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->double('amount')->nullable();
            $table->date('will_expire')->nullable();
            $table->boolean('is_trial')->default(0);
            $table->json('meta')->nullable();
            $table->integer('status')->default(2); //1= active 0=failed/cancel 2= pending 3=expired
            $table->integer('payment_status')->default(2); //1= active 0=failed/cancel 2= pending 3=expired
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
        Schema::dropIfExists('subscriptions');
    }
};
