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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('unit',30);
            $table->string('spesifikasi',100);
            $table->string('nopol',30);
            $table->string('tahun',30);
            $table->bigInteger('harga');
            $table->string('foto1',100);
            $table->string('foto2',100);
            $table->string('foto3',100);
            $table->string('foto4',100);
            $table->integer('status');
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
        Schema::dropIfExists('mobils');
    }
};
