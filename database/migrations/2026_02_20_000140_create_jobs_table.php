<?php

use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\JobUrgency;
use App\Enums\SalaryType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('job_title')->index();
            $table->string('job_category')->nullable()->index();
            $table->string('job_type')->index();
            $table->unsignedSmallInteger('vacancy_count')->default(1);
            $table->unsignedInteger('salary_min')->nullable()->index();
            $table->unsignedInteger('salary_max')->nullable()->index();
            $table->string('salary_type')->nullable()->index();
            $table->unsignedTinyInteger('experience_min_year')->nullable();
            $table->unsignedTinyInteger('experience_max_year')->nullable();
            $table->string('education_requirement')->nullable();
            $table->string('job_location')->nullable()->index();
            $table->date('application_deadline')->nullable()->index();
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->string('urgency')->default(JobUrgency::LOW->value)->index();
            $table->string('status')->default(JobStatus::DRAFT->value)->index();
            $table->json('attachments')->nullable();
            $table->timestamps();
        });

        Schema::create('job_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_posts')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->unique(['job_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_skill');
        Schema::dropIfExists('job_posts');
    }
};
