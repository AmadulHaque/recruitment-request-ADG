<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('request_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('recruitment_request_id');
            $table->string('path');
            $table->string('mime')->nullable();
            $table->string('original_name')->nullable();
            $table->timestamps();

            $table->foreign('recruitment_request_id')->references('id')->on('recruitment_requests')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_attachments');
    }
};

