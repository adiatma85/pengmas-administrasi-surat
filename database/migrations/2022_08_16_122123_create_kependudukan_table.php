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
        Schema::create('kependudukans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('nik');
            $table->date('birthdate');
            $table->string('birthplace');
            $table->string('gender');
            $table->string('religion');
            $table->string('marital_status');
            $table->string('latest_education');
            $table->string('occupation');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('disease');
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
        Schema::dropIfExists('kependudukans');
    }
};