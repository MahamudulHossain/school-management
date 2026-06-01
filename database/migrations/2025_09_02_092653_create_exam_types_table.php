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
        Schema::create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->string('examtype_name');

            $table->BigInteger('school_class_id')->unsigned();
            $table->foreign('school_class_id')->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('term_id')->unsigned();
            $table->foreign('term_id')->references('id')->on('terms')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('exam_criteria_id');
            $table->foreign('exam_criteria_id')->references('id')->on('exam_criterias')->onDelete('cascade');

            $table->float('full_marks',6,2);
            $table->float('pass_marks',6,2);
            $table->string('exam_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_types');
    }
};
