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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('user_id');
            $table->uuid('voucher_id');
            $table->uuid('category_id');
            $table->string('code');
            $table->date('date');
            $table->string('voucher_code');
            $table->string('voucher_name');
            $table->integer('voucher_active_period');
            $table->enum('voucher_access_type', ['basic_member', 'standard_member', 'premium_member']);
            $table->json('voucher_sub_categories')->nullable();
            $table->enum('voucher_type', ['week', 'month', 'year']);
            $table->double('voucher_price_before_discount');
            $table->double('voucher_price_after_discount');
            $table->double('voucher_nominal_discount');
            $table->date('voucher_expired_date')->nullable();
            $table->tinyInteger('voucher_activated')->default(0);
            $table->tinyInteger('voucher_used')->default(0);
            $table->double('total_purchases');
            $table->datetime('maximum_payment_time');
            $table->enum('transaction_status', ['pending', 'paid', 'failed', 'done']);
            $table->string('voucher_token')->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('voucher_id')
                  ->references('id')
                  ->on('vouchers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
