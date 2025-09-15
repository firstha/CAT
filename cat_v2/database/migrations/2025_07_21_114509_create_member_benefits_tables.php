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
        Schema::create('member_benefits', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    Schema::create('member_levels', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique(); 
        $table->timestamps();
    });

    Schema::create('benefit_level', function (Blueprint $table) {
        $table->id();
        $table->foreignId('member_benefit_id')->constrained('member_benefits')->onDelete('cascade');
        $table->foreignId('member_level_id')->constrained('member_levels')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefit_level');
    Schema::dropIfExists('member_levels');
    Schema::dropIfExists('member_benefits');
    }
};
