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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('school_class_id')->unsigned();
            $table->foreign('school_class_id')->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('school_section_id')->unsigned();
            $table->foreign('school_section_id')->references('id')->on('school_sections')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('academic_year_id')->unsigned();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('attendance_by')->unsigned();
            $table->foreign('attendance_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('roll');
            $table->date('date');
            $table->enum('attendance', ['Present', 'Absent']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
