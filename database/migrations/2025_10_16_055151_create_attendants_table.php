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
        Schema::create('attendants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email')->unique()->nullable();
            $table->string('contact_no')->unique()->nullable();
            $table->string('nid')->nullable();
            $table->text('address')->nullable();
            $table->enum('gender',['Male','Female','Others'])->nullable()->default('Male');
            $table->string('image')->default('default_image.png');
            $table->timestamps();
        });

        // Pivot table
        Schema::create('attendant_student', function (Blueprint $table) {
            $table->foreignId('attendant_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->primary(['attendant_id', 'student_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendants');
    }
};
