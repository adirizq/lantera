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
        Schema::create('kader', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('puskesmas_id')->constrained('puskesmas')->onDelete('cascade');
            $table->timestamp('verified_at')->nullable();
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->text('alamat_domisili');
            $table->foreignId('id_provinsi')->constrained('indonesia_provinces')->onDelete('cascade');
            $table->foreignId('id_kota')->constrained('indonesia_cities')->onDelete('cascade');
            $table->foreignId('id_kecamatan')->constrained('indonesia_districts')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('indonesia_villages')->onDelete('cascade');
            $table->string('rt');
            $table->string('rw');
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
        Schema::dropIfExists('kader');
    }
};
