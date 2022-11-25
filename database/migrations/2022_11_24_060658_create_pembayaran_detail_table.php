<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_detail', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan');
            $table->integer('id_menu');
            $table->decimal('harga', 16,2);
            $table->integer('jumlah_pesanan');
            $table->decimal('total_harga', 16,2);
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
        Schema::dropIfExists('pembayaran_detail');
    }
}
