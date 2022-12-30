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
        // Table 'kependudukans'
        Schema::table('kependudukans', function (Blueprint $table) {
            // Optional foreign key
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Table 'kependudukans'
        Schema::table('kependudukans', function (Blueprint $table) {
            $table->removeColumn('user_id');
        });
    }
};
