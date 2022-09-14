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
            $table->string('rt_rw')->nullable()->after('disease')->default('04/08');
            $table->string('postal_code')->nullable()->after('rt_rw')->default('620286');
            $table->string('kelurahan')->nullable()->after('postal_code')->default('Tulusrejo');
            $table->string('kecamatan')->nullable()->after('kelurahan')->default('Lowokwaru');
            $table->string('city')->nullable()->after('kecamatan')->default('Malang');
            $table->string('province')->nullable()->after('city')->default('Jawa Timur');
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
            $table->removeColumn('rt_rw');
            $table->removeColumn('postal_code');
            $table->removeColumn('kelurahan');
            $table->removeColumn('kecamatan');
            $table->removeColumn('city');
            $table->removeColumn('province');
        });
    }
};
