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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->longText('first_name')->nullable()->comment('First Name of the student');
            $table->longText('last_name')->nullable()->comment('Last Name of the student');
            $table->string('address')->nullable()->comment('Address of the student');
            $table->unsignedBigInteger('program_id')->comment('ID table programs');
            $table->string('registration_number')->unique()->nullable()->comment('Student Registration Number of the student');
            $table->string('contact_number')->nullable()->comment('Contact Number of the student');
            $table->date('start_program_date')->comment('Date of Start Program');
            $table->date('end_program_date')->nullable()->comment('Date of End Program');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
