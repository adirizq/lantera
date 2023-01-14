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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansia')->onDelete('cascade');
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaan');
            $table->string('score_malnutrisi');
            $table->string('score_penglihatan');
            $table->string('score_pendengaran');
            $table->string('score_mobilitas');
            $table->string('score_kognitif');
            $table->string('score_gejala_depresi');
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
        Schema::dropIfExists('scores');
    }
};
