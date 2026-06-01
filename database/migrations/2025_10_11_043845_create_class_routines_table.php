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
        Schema::create('class_routines', function (Blueprint $table) {
            $table->id();

            $table->BigInteger('school_class_id')->unsigned();
            $table->foreign('school_class_id')->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('school_section_id')->unsigned();
            $table->foreign('school_section_id')->references('id')->on('school_sections')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('academic_year_id')->unsigned();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('shift')->nullable();
            $table->string('day_of_week')->nullable();

            $table->unsignedTinyInteger('period_number');

            $table->BigInteger('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')
                ->on('subjects')->onUpdate('cascade')->onDelete('cascade');

            // NEW: Foreign key for Teacher
            $table->BigInteger('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')
                ->on('teachers')->onUpdate('cascade')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_routines');
    }
};
