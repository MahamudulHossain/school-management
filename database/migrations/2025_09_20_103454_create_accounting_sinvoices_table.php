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
        Schema::create('accounting_sinvoices', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->BigInteger('accounting_sfee_id')->unsigned();
            $table->foreign('accounting_sfee_id')->references('id')->on('accounting_sfees')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->float('fee_amount',6,2);
            $table->float('fine_amount',6,2)->nullable();
            $table->float('discount_amount',6,2)->nullable();
            $table->float('collect_amount',6,2)->nullable();

            $table->BigInteger('academic_year_id')->unsigned();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->date('due_date');
            $table->date('collect_date')->nullable();
            $table->integer('is_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_sinvoices');
    }
};
