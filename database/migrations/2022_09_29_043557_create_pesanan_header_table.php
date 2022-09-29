<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan_header', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 14);
            $table->date('tanggal_pesanan');
            $table->string('tipe_pesanan', 10);
            $table->integer('id_reservasi')->nullable();
            $table->string('nama_penerima', 35)->nullable();
            $table->string('no_hp_penerima', 16)->nullable();
            $table->text('alamat_penerima')->nullable();
            $table->text('catatan')->nullable();
            $table->decimal('total', 16,2);
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
        Schema::dropIfExists('pesanan_header');
    }
}
