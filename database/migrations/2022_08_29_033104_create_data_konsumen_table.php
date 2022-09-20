<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKonsumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_konsumen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 35);
            $table->string('nomor_telepon', 16);
            $table->string('no_ktp', 16);
            $table->text('alamat_domisili');
            $table->text('email');
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
        Schema::dropIfExists('data_konsumen');
    }
}
