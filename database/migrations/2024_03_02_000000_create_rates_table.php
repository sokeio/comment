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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->morphs('rateable');
            $table->decimal('rate')->default(0);
            $table->json('rates')->nullable();
            $table->timestamps();
        });
        Schema::create('rate_users', function (Blueprint $table) {
            $table->id();
            $table->integer('rate')->default(0);
            $table->foreignId('rate_id');
            $table->foreignId('user_id')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_users');
        Schema::dropIfExists('rates');
    }
};
