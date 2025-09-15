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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('category_id')->nullable();
            $table->string('code');
            $table->string('name');
            $table->integer('user_limit')->nullable();
            $table->integer('active_period');
            $table->enum('access_type', ['basic_member', 'standard_member', 'premium_member', 'vip_member']);
            $table->enum('type', ['week', 'month', 'year']);
            $table->double('price_before_discount');
            $table->double('price_after_discount');
            $table->text('description');
            $table->tinyInteger('is_active');

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
        Schema::dropIfExists('vouchers');
    }
};
