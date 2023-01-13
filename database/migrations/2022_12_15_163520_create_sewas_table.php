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
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_sewa', ['Lepas', 'Kunci'])->default('Lepas');
            $table->string('kode', 30)->unique();
            $table->string('nopol', 200);
            $table->string('unit', 200);
            $table->string('tahun', 200);
            $table->string('harga_bulan')->comment('bulan/hari');
            $table->string('harga');
            $table->string('nik', 100);
            $table->string('sopir_id', 100)->nullable();

            $table->string('penanggung_jawab', 100);
            $table->string('tujuan', 100);
            $table->string('jaminan', 100)->nullable();
            $table->string('denda', 100);
            $table->string('pdf_url', 100);
            $table->string('status',20);
            $table->string('sisa',30)->nullable();
            $table->string('panjar',30)->nullable();
            $table->string('total',30);
            $table->string('metode_bayar',30);
            $table->string('list_pengiriman',100)->nullable();
            $table->enum('status_bayar',['1','2','3', '4'])->comment('1 = Lunas, 2 = Denda, 3=belum lunas, 4= menunggak Pembayaran');

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
        Schema::dropIfExists('sewas');
    }
};
