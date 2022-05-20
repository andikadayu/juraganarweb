<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableShopeescrap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_shopeescrap', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->date('date_scrape');
            $table->text('url_scrape')->nullable();
            $table->text('nama_produk')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('cat1')->nullable();
            $table->integer('berat')->nullable();
            $table->integer('minimum_pemesanan')->nullable();
            $table->integer('nomor_etalase')->nullable();
            $table->integer('waktu_preorder')->nullable();
            $table->text('kondisi')->nullable();
            $table->text('gambar1')->nullable();
            $table->text('video1')->nullable();
            $table->text('sku_name')->nullable();
            $table->text('status')->nullable();
            $table->integer('jumlah_stok')->nullable();
            $table->integer('harga')->nullable();
            $table->text('asuransi')->nullable();

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
        Schema::dropIfExists('table_shopeescrap');
    }
}
