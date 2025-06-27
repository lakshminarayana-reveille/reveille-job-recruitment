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
        Schema::create('job_application_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_application_id');
            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');
            $table->string('response_type'); // e.g., 'accepted', 'rejected', 'interview', etc.
            $table->text('response_message')->nullable(); // Optional message for the response
            $table->string('responded_by'); // e.g., 'HR', 'Manager', etc.
            $table->string('responded_to'); // e.g., 'applicant', 'recruiter', etc.
            $table->string('status')->default('pending'); // e.g., 'pending', 'completed', etc.
            $table->date('date_of_interview')->nullable(); // Optional date for interview if applicable
            $table->time('time_of_interview')->nullable(); // Optional time for interview if applicable
            $table->string('interview_location')->nullable(); // Optional location for interview if applicable
            $table->string('interview_mode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_application_responses');
    }
};
