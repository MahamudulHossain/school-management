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
        Schema::create('shift_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('shift_id');
            $table->integer('period_number')->nullable();
            $table->enum('type', ['regular', 'assembly', 'tiffin'])->default('regular');
            $table->string('title')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_periods');
    }
};
