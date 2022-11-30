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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->onDelete('cascade');
            $table->foreignId('kader_id')->constrained('kader')->onDelete('cascade');
            $table->decimal('suhu_tubuh', 3, 1);
            $table->integer('tekanan_darah_sistole');
            $table->integer('tekanan_darah_diastole');
            $table->integer('denyut_nadi');
            $table->integer('kolestrol');
            $table->integer('glukosa');
            $table->string('kondisi');
            $table->integer('asam_urat');
            $table->integer('respiratory_rate');
            $table->integer('spo2');
            $table->decimal('berat_badan', 3, 1);
            $table->decimal('lingkar_perut', 3, 1);
            $table->string('swab');
            $table->string('sub_1_pola_makan');
            $table->string('sub_1_pola_bab');
            $table->string('sub_1_puasa');
            $table->string('sub_1_catatan')->nullable();
            $table->string('sub_2_pola_minum');
            $table->string('sub_2_pola_bak');
            $table->string('sub_2_catatan')->nullable();
            $table->string('sub_3_tarik_napas');
            $table->string('sub_3_buang_napas');
            $table->string('sub_3_catatan')->nullable();
            $table->string('sub_4_tidur');
            $table->string('sub_4_bangun_tidur');
            $table->string('sub_4_catatan')->nullable();
            $table->string('sub_5_pola_seksual');
            $table->string('sub_5_catatan')->nullable();
            $table->string('sub_6_penglihatan');
            $table->string('sub_6_catatan')->nullable();
            $table->string('sub_7_pendengaran');
            $table->string('sub_7_catatan')->nullable();
            $table->string('sub_8_perasa');
            $table->string('sub_8_catatan')->nullable();
            $table->string('sub_9_penciuman');
            $table->string('sub_9_catatan')->nullable();
            $table->string('sub_10_mobilitas');
            $table->string('sub_10_catatan')->nullable();
            $table->string('sub_11_pendapatan');
            $table->string('sub_11_catatan')->nullable();
            $table->string('sub_12_aktivitas_sosial');
            $table->string('sub_12_catatan')->nullable();
            $table->string('sub_13_ibadah');
            $table->string('sub_13_catatan')->nullable();
            $table->string('sub_14_dukungan_keluarga');
            $table->string('sub_14_catatan')->nullable();
            $table->string('sub_15_tinggal_bersama');
            $table->string('sub_15_catatan')->nullable();
            $table->string('keluhan_utama');
            $table->string('tindakan_perawatan');
            $table->string('tindakan_kedokteran');
            $table->string('foto');
            $table->dateTime('mulai_pemeriksaan');
            $table->dateTime('selesai_pemeriksaan');
            $table->string('longitude');
            $table->string('latitude');
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
        Schema::dropIfExists('pemeriksaan');
    }
};
