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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('foto_ktp',200)->nullable();
            $table->string('nik',30)->unique();
            $table->string('nama',100);
            $table->string('alamat',100);
            $table->string('pekerjaan',100);
            $table->string('no_hp',30);
            $table->string('no_hp_lain',30);
            $table->string('tempat_lahir',50);
            $table->date('tgl_lahir');
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
        Schema::dropIfExists('penggunas');
    }
};
