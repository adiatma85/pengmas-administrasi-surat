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
        Schema::table('kependudukans', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('mother_occupation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kependudukans', function (Blueprint $table) {
            $table->removeColumn('phone_number');
        });
    }
};
