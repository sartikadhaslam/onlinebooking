<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_header', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 14);
            $table->date('tanggal_pembayaran')->nullable();
            $table->integer('id_konsumen');
            $table->decimal('total_tagihan', 16,2);
            $table->decimal('total_tagihan_ppn', 16,2);
            $table->decimal('jumlah_pembayaran', 16,2)->nullable();
            $table->text('metode_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->text('status');
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
        Schema::dropIfExists('pembayaran_header');
    }
}
