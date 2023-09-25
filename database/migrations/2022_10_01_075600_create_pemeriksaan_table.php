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
            $table->foreignId('kader_id')->constrained('kader');
            $table->mediumText('json_data_phce');
            $table->mediumText('json_data_subjektif');
            $table->mediumText('json_data_keluhan');
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
