<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('application_status_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('candidate_application_id');
            $table->string('status');
            $table->json('data')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();

            $table->foreign('candidate_application_id')->references('id')->on('candidate_applications')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_status_history');
    }
};

