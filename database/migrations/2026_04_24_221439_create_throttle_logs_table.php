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
        Schema::create('throttle_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->index();
            $table->string('url');
            $table->string('middleware')->nullable();
            $table->string('method');

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('throttle_logs');
    }
};
