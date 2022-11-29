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
        Schema::create('lansia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posyandu_id')->constrained('posyandu')->onDelete('cascade');
            $table->string('no_ktp')->unique();
            $table->string('no_kk');
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->foreignId('id_provinsi')->constrained('indonesia_provinces')->onDelete('cascade');
            $table->foreignId('id_kota')->constrained('indonesia_cities')->onDelete('cascade');
            $table->foreignId('id_kecamatan')->constrained('indonesia_districts')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('indonesia_villages')->onDelete('cascade');
            $table->string('rt');
            $table->string('rw');
            $table->text('alamat_domisili');
            $table->text('alamat_ktp');
            $table->string('pekerjaan')->nullable();
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
        Schema::dropIfExists('lansia');
    }
};
