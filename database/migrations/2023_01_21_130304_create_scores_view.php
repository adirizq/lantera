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
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }


    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW view_scores AS SELECT 
            
            *,

            CASE 
                WHEN (score_malnutrisi > 0 AND score_malnutrisi < 11) THEN 'NORMAL' 
                WHEN (score_malnutrisi > 10 AND score_malnutrisi < 21) THEN 'BERESIKO' 
                WHEN (score_malnutrisi > 20 AND score_malnutrisi < 31) THEN 'GANGGUAN'
                ELSE 'ERROR'
            END AS 'status_malnutrisi',

            CASE 
                WHEN (score_penglihatan > 10 AND score_malnutrisi < 22) THEN 'NORMAL' 
                WHEN (score_penglihatan > 21 AND score_malnutrisi < 33) THEN 'BERESIKO' 
                WHEN (score_penglihatan > 32 AND score_malnutrisi < 45) THEN 'GANGGUAN'
                ELSE 'ERROR'
            END AS 'status_penglihatan',

            CASE 
                WHEN (score_pendengaran > 0 AND score_malnutrisi < 18) THEN 'NORMAL' 
                WHEN (score_pendengaran > 17 AND score_malnutrisi < 27) THEN 'BERESIKO' 
                WHEN (score_pendengaran > 26) THEN 'GANGGUAN'
                ELSE 'ERROR'
            END AS 'status_pendengaran',

            CASE 
                WHEN (score_mobilitas > 0 AND score_malnutrisi < 23) THEN 'NORMAL' 
                WHEN (score_mobilitas > 22 AND score_malnutrisi < 35) THEN 'BERESIKO' 
                WHEN (score_mobilitas > 34) THEN 'GANGGUAN'
                ELSE 'ERROR'
            END AS 'status_mobilitas',

            CASE 
                WHEN (score_kognitif > 0 AND score_malnutrisi < 15) THEN 'NORMAL' 
                WHEN (score_kognitif > 14 AND score_malnutrisi < 29) THEN 'BERESIKO' 
                WHEN (score_kognitif > 28 AND score_malnutrisi < 43) THEN 'GANGGUAN'
                ELSE 'ERROR'
            END AS 'status_kognitif',

            CASE 
                WHEN (score_gejala_depresi > 0 AND score_malnutrisi < 33) THEN 'NORMAL' 
                WHEN (score_gejala_depresi > 32 AND score_malnutrisi < 49) THEN 'BERESIKO' 
                WHEN (score_gejala_depresi > 48) THEN 'GANGGUAN'
                ELSE 'ERROR'
            END AS 'status_gejala_depresi'

            FROM `scores`
            SQL;
    }

    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS `view_scores`;
            SQL;
    }
};
