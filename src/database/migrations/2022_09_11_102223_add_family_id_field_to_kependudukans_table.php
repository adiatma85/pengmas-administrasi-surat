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
            $table->unsignedBigInteger('family_id')->after('user_id')->nullable();
            $table->foreign('family_id', 'family_id_fk_kependudukan')->references('id')->on('families');
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
            $table->dropForeign('family_id_fk_kependudukan');
            $table->removeColumn('family_id');
        });
    }
};
