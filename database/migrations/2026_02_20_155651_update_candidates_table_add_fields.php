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
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('recruiter_id')->nullable()->after('user_id');
            $table->integer('availability_weeks')->nullable()->after('availability');
            $table->text('cover_letter')->nullable()->after('about_me');
            $table->boolean('has_consented')->default(false)->after('cv_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['recruiter_id', 'availability_weeks', 'cover_letter', 'has_consented']);
        });
    }
};
