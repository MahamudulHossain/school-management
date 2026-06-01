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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('emergency_contract')->nullable();
            $table->string('pre_house')->nullable();
            $table->string('pre_road')->nullable();
            $table->string('pre_state')->nullable(); //state,ward,union
            $table->string('pre_post')->nullable(); //post with code
            $table->string('pre_thana')->nullable(); //thana,upazila
            $table->string('pre_district')->nullable();
            $table->string('pre_division')->nullable();
            $table->string('pre_country')->nullable();
            $table->string('present_permanent')->nullable();
            $table->string('per_house')->nullable();
            $table->string('per_road')->nullable();
            $table->string('per_state')->nullable(); //state,ward,union
            $table->string('per_post')->nullable(); //post with code
            $table->string('per_thana')->nullable(); //thana,upazila
            $table->string('per_district')->nullable();
            $table->string('per_division')->nullable();
            $table->string('per_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
