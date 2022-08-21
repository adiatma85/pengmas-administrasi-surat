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
        Schema::create('mail_data', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('nik')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('latest_education')->nullable();
            $table->string('occupation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_religion')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_marital_statu')->nullable();
            $table->string('father_address')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_religion')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_marital_statu')->nullable();
            $table->string('mother_address')->nullable();
            $table->string('disease')->nullable();
            $table->string('keterangan_surat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_data');
    }
};
