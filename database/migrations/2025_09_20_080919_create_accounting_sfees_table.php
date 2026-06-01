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
        Schema::create('accounting_sfees', function (Blueprint $table) {
            $table->id();
            $table->string('fee_name');
            $table->string('description')->nullable();
            $table->BigInteger('school_class_id')->unsigned();
            $table->foreign('school_class_id')->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->float('amount',6,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_sfees');
    }
};
