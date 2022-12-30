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
            $table->string('father_religion')->nullable()->after('father_name');
            $table->string('father_occupation')->nullable()->after('father_religion');
            $table->string('mother_religion')->nullable()->after('mother_name');
            $table->string('mother_occupation')->nullable()->after('mother_religion');
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
            $table->removeColumn('father_religion');
            $table->removeColumn('father_occupation');
            $table->removeColumn('mother_religion');
            $table->removeColumn('mother_occupation');
        });
    }
};
