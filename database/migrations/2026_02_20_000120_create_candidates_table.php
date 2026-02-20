<?php

use App\Enums\JobType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('headline')->nullable();
            $table->unsignedInteger('expected_salary_min')->nullable();
            $table->unsignedInteger('expected_salary_max')->nullable();
            $table->string('preferred_job_type')->nullable()->index();
            $table->string('preferred_location')->nullable()->index();
            $table->unsignedTinyInteger('total_experience_years')->nullable();
            $table->string('availability')->nullable();
            $table->text('about_me')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('cv_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};

