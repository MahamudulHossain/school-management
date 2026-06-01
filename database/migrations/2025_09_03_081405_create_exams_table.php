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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('school_class_id')->unsigned();
            $table->foreign('school_class_id')->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('school_section_id')->unsigned();
            $table->foreign('school_section_id')->references('id')->on('school_sections')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onUpdate('cascade')->onDelete('cascade');

            // $table->BigInteger('teacher_id')->unsigned();
            // $table->foreign('teacher_id')->references('id')->on('teachers')
            //     ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('exam_type_id')->unsigned();
            $table->foreign('exam_type_id')->references('id')->on('exam_types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('academic_year_id')->unsigned();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('roll');
            $table->float('exam_mark',6,2)->nullable();
            $table->float('obtain_mark',6,2)->nullable();
            $table->float('added_mark',6,2)->nullable();
            $table->string('examtype_name');
            $table->string('fail_pass')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
