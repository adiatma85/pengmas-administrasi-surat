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
        Schema::table('mail_data', function (Blueprint $table) {
            // Surat keterangan domisili
            $table->string('owner_house_name')->nullable()->after('domicile_status');
            $table->text('base_64_owner_house_signature')->nullable()->after('owner_house_name');
            // Surat keterangan belum menikah
            $table->string('alamat_orang_tua')->nullable()->after('base_64_owner_house_signature');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_data', function (Blueprint $table) {
            // Surat keterangan domisili
            $table->removeColumn('owner_house_name');
            $table->removeColumn('base_64_owner_house_signature');
            // Surat keterangan belum menikah
            $table->removeColumn('alamat_orang_tua');
        });
    }
};
