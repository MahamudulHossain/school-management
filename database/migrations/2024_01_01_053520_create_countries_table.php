<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('country_title',50);
            $table->string('country_code',5)->nullable();
            $table->string('flag',50)->nullable();
            $table->string('phone_code',5)->nullable();
            $table->string('language_code',5)->nullable();
            $table->string('currency_title',50)->nullable();
            $table->string('currency_code',5)->nullable();
            $table->string('currency_major',10)->nullable();
            $table->string('currency_minor',10)->nullable();
            $table->string('currency_symbol',10)->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
