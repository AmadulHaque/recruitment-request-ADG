<?php

use App\Enums\ApplicationFinalStatus;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_posts')->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->string('application_status')->default(ApplicationStatus::APPLIED->value)->index();
            $table->dateTime('interview_date')->nullable()->index();
            $table->text('interview_note')->nullable();
            $table->string('final_status')->nullable()->index();
            $table->timestamps();
            $table->unique(['job_id', 'candidate_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
