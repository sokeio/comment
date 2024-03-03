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
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->morphs('viewable');
            $table->integer('count')->default(0);
            $table->timestamps();
        });
        Schema::create('view_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('view_id');
            $table->integer('count')->default(0);
            $table->string('country_code')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->timestamps();
        });
        Schema::create('view_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('view_id');
            $table->foreignId('user_id')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country_code')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_users');
        Schema::dropIfExists('views');
    }
};
