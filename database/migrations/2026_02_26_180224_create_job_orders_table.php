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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'in_progress', 'completed','reopened','under_review','closed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->foreignId('assigned_by')->nullable()->constrained('employees')->onDelete('cascade');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('employees')->onDelete('cascade');
            $table->timestamp('closed_at')->nullable();
            $table->text('closure_reason')->nullable();
            $table->foreignId('complaint_id')->constrained('complaints')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
