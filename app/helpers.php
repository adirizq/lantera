<?php

if (!function_exists('status_element')) {
    function status_element($status, $display)
    {
        if ($status == 'NORMAL') {
            return '<span class="badge bg-success my-1">' . $display . '</span> ';
        } elseif ($status == 'BERESIKO') {
            return '<span class="badge bg-warning my-1">' . $display . '</span> ';
        } elseif ($status == 'GANGGUAN') {
            return '<span class="badge bg-danger my-1">' . $display . '</span> ';
        }
    }
}

if (!function_exists('find_gangguan')) {
    function find_gangguan($status_malnutrisi, $status_penglihatan, $status_pendengaran, $status_mobilitas, $status_kognitif, $status_gejala_depresi)
    {
        $value = '<p class="mb-0" style="line-height:1;">';

        if ($status_malnutrisi == 'GANGGUAN') {
            $value .= '<span class="badge bg-danger">MALNUTRISI</span> &nbsp; ';
        }

        if ($status_penglihatan == 'GANGGUAN') {
            $value .= '<span class="badge bg-danger">PENGLIHATAN</span> &nbsp; ';
        }

        if ($status_pendengaran == 'GANGGUAN') {
            $value .= '<span class="badge bg-danger">PENDENGARAN</span> &nbsp; ';
        }

        if ($status_mobilitas == 'GANGGUAN') {
            $value .= '<span class="badge bg-danger">MOBILITAS</span> &nbsp; ';
        }

        if ($status_kognitif == 'GANGGUAN') {
            $value .= '<span class="badge bg-danger">KOGNITIF</span> &nbsp; ';
        }

        if ($status_gejala_depresi == 'GANGGUAN') {
            $value .= '<span class="badge bg-danger">DEPRESI</span> &nbsp; ';
        }

        return $value . '</p>';
    }
}
