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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('position_applied');
            $table->date('dob');
            $table->string('gender');
            $table->string('blood_group')->nullable();
            $table->string('marital_status');
            $table->string('nationality');
            $table->text('present_address');
            $table->text('permanent_address')->nullable();
            $table->string('education_qualification');
            $table->integer('total_experience')->default(0);
            $table->integer('relevant_experience')->nullable();
            $table->string('current_ctc');
            $table->string('expected_ctc');
            $table->boolean('applied_before');
            $table->text('applied_before_details')->nullable();
            $table->boolean('has_relatives');
            $table->text('relatives_details')->nullable();
            $table->json('references')->nullable();
            $table->string('resume_path');
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
