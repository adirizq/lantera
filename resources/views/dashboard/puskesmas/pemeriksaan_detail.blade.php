@extends('dashboard.layouts.main')

@section('head-assets')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />

    <style>
        .table-variable {
            width: 300px;
        }

        #map {
            height: 200px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Data Pemeriksaan</h4>
                    <div class="row mt-4">
                        <div class="col-xxl-3 col-xl-4 col-12 mb-5">
                            <div class="alert alert-primary py-4 px-3">
                                <h6 class="alert-heading mb-0">ID Pemeriksaan</h6>
                                <p class="card-text mt-1 mb-3">{{ $pemeriksaan->id }}</p>
                                <h6 class="alert-heading mb-0">Nama Lansia</h6>
                                <p class="card-text mt-1 mb-3">{{ $pemeriksaan->lansia->nama }}</p>
                                <h6 class="alert-heading mb-0">No KTP Lansia</h6>
                                <p class="card-text mt-1 mb-3">{{ $pemeriksaan->lansia->no_ktp }}</p>
                                <h6 class="alert-heading mb-0">Nama Kader</h6>
                                <p class="card-text mt-1 mb-3">{{ $pemeriksaan->kader->nama }}</p>
                                <h6 class="alert-heading mb-0">ID Kader</h6>
                                <p class="card-text mt-1 mb-3">{{ $pemeriksaan->kader->id }}</p>
                                <h6 class="alert-heading mb-0">Waktu Pemeriksaan</h6>
                                <p class="card-text mt-1 mb-3">{{ $pemeriksaan->created_at }}</p>
                                <h6 class="alert-heading mb-0">Lokasi Pemeriksaan</h6>
                                <div class="px-2 mt-1">
                                    <div id="map"></div>
                                </div>
                                <h6 class="alert-heading mb-0 mt-3">Foto Pemeriksaan</h6>
                                <div class="px-2 mt-1">
                                    <img src="{{ url('storage/' . $pemeriksaan->foto) }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-9 col-xl-8 col-12">
                            <div class="row mb-3">
                                @foreach ($scores->getAttributes() as $key => $s)
                                    @if (str_contains($key, 'score'))
                                        @if ($scores->{str_replace('score', 'status', $key)} == 'NORMAL')
                                            <div class="col">
                                                <div class="card safe-score-card mb-3">
                                                    <div class="card-body px-3 py-3">
                                                        <div class="row flex-nowrap">
                                                            <div class="score-fixed d-flex justify-content-start ">
                                                                <div class="stats-icon safe-score mb-0 px-2">
                                                                    <h3 class="mb-0 no-space-text white-text">{{ $s }}</h3>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="font-semibold mb-1 dark-text no-wrap-text">{{ ucfirst(str_replace('_', ' ', str_replace('score_', '', $key))) }}</h6>
                                                                <h4 class="safe-score-text font-extrabold mb-0 no-space-text no-wrap-text">NORMAL</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($scores->{str_replace('score', 'status', $key)} == 'BERESIKO')
                                            <div class="col">
                                                <div class="card warning-score-card mb-3">
                                                    <div class="card-body px-3 py-3">
                                                        <div class="row flex-nowrap">
                                                            <div class="score-fixed d-flex justify-content-start ">
                                                                <div class="stats-icon warning-score mb-0 px-2">
                                                                    <h3 class="mb-0 no-space-text white-text">{{ $s }}</h3>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="font-semibold mb-1 dark-text no-wrap-text">{{ ucfirst(str_replace('_', ' ', str_replace('score_', '', $key))) }}</h6>
                                                                <h4 class="warning-score-text font-extrabold mb-0 no-space-text no-wrap-text">BERESIKO</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($scores->{str_replace('score', 'status', $key)} == 'GANGGUAN')
                                            <div class="col">
                                                <div class="card danger-score-card mb-3">
                                                    <div class="card-body px-3 py-3">
                                                        <div class="row flex-nowrap">
                                                            <div class="score-fixed d-flex justify-content-start ">
                                                                <div class="stats-icon danger-score mb-0 px-2">
                                                                    <h3 class="mb-0 no-space-text white-text">{{ $s }}</h3>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="font-semibold mb-1 dark-text no-wrap-text">{{ ucfirst(str_replace('_', ' ', str_replace('score_', '', $key))) }}</h6>
                                                                <h4 class="danger-score-text font-extrabold mb-0 no-space-text no-wrap-text">GANGGUAN</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col">
                                                <div class="card danger-score-card mb-3">
                                                    <div class="card-body px-3 py-3">
                                                        <div class="row flex-nowrap">
                                                            <div class="score-fixed d-flex justify-content-start ">
                                                                <div class="stats-icon danger-score mb-0 px-2">
                                                                    <h3 class="mb-0 no-space-text white-text px-2">E</h3>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="font-semibold mb-1 dark-text no-wrap-text">Error</h6>
                                                                <h4 class="danger-score-text font-extrabold mb-0 no-space-text no-wrap-text">ERROR</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-bold active" id="phce-tab" data-bs-toggle="tab" href="#phce" role="tab" aria-controls="phce" aria-selected="true">Pemeriksaan PHCe</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-bold" id="subjektif-tab" data-bs-toggle="tab" href="#subjektif" role="tab" aria-controls="subjektif" aria-selected="false" tabindex="-1">Data Subjektif</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-bold" id="keluhan-tab" data-bs-toggle="tab" href="#keluhan" role="tab" aria-controls="keluhan" aria-selected="false" tabindex="-1">Keluhan Lansia</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active py-3" id="phce" role="tabpanel" aria-labelledby="phce-tab">
                                    <div class="alert alert-light">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Suhu Tubuh</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Suhu Tubuh'] ?? 'Tidak ada data' }} &#8451;</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Tekanan Darah</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Tekanan Darah Sistole'] ?? 'Tidak ada data' }} / {{ $phce['Tekanan Darah Diastole'] ?? 'Tidak ada data' }} mmHg</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Denyut Nadi</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Denyut Nadi'] ?? 'Tidak ada data' }} BPM</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Kolesterol</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Kolestrol'] ?? 'Tidak ada data' }} mg/dL</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Glukosa</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Glukosa'] ?? 'Tidak ada data' }} mg/dL</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Kondisi Saat Periksa Glukosa</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Kondisi saat Periksa Glukosa'] ?? 'Tidak ada data' }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Asam Urat</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Asam Urat'] ?? 'Tidak ada data' }} mg/dL</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Respiratory Rate</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Respiratory Rate'] ?? 'Tidak ada data' }} / Menit</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">SpO2</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['SpO2'] ?? 'Tidak ada data' }} / %</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Berat Badan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Berat Badan'] ?? 'Tidak ada data' }} Kg</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Tinggi Badan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Tinggi Badan'] ?? 'Tidak ada data' }} cm</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Linkar Lengan Atas</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Lingkar Lengan Atas'] ?? 'Tidak ada data' }} cm</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Linkar Perut</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Lingkar Perut'] ?? 'Tidak ada data' }} cm</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Status Vaksin</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $phce['Status Vaksin'] ?? 'Tidak ada data' }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Keterangan Vaksin</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ isset($phce['Dosis Vaksin']) ? $phce['Dosis Vaksin'] ?? 'Tidak ada data' : $phce['Alasan belum vaksin'] ?? 'Tidak ada data' }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade py-3" id="subjektif" role="tabpanel" aria-labelledby="subjektif-tab">
                                    @foreach ($subjektif as $key => $s)
                                        <div class="alert alert-light">
                                            <h6 class="alert-heading mb-3">{{ $key }}</h6>
                                            <div class="table-responsive">
                                                <table class="table table-hover table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="table-variable">
                                                                <h6 class="mb-0">Catatan</h6>
                                                            </td>
                                                            <td>
                                                                <p class="card-text">{{ $s['catatan'] ?? 'Tidak ada catatan' }}</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 1</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Pola Makan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_1_pola_makan }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Pola BAB</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_1_pola_bab }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Puasa</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_1_puasa }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_1_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 2</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Pola Minum</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_2_pola_minum }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Pola BAK</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_2_pola_bak }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_2_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 3</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Tarik Napas</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_3_tarik_napas }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Buang Napas</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_3_buang_napas }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_3_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 4</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Tidur</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_4_tidur }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Bangun Tidur</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_4_bangun_tidur }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_4_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 5</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Pola Seksual</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_5_pola_seksual }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_5_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 6</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Penglihatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_6_penglihatan }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_6_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 7</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Pendengaran</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_7_pendengaran }}</p>
                                                        </td>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_7_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 8</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Perasa</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_8_perasa }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_8_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 9</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Penciuman</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_9_penciuman }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_9_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 10</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Mobilitas</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_10_mobilitas }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_10_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 11</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Pendapatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_11_pendapatan }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_11_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 12</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Aktivitas Sosial</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_12_aktivitas_sosial }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_12_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 13</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Ibadah</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_13_ibadah }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_13_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 14</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Dukungan Keluarga</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_14_dukungan_keluarga }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_14_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="alert alert-light">
                                        <h6 class="alert-heading mb-3">Data Sub 15</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Tinggal Bersama</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_15_tinggal_bersama }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-variable">
                                                            <h6 class="mb-0">Catatan</h6>
                                                        </td>
                                                        <td>
                                                            <p class="card-text">{{ $pemeriksaan->sub_15_catatan }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="tab-pane fade py-3" id="keluhan" role="tabpanel" aria-labelledby="keluhan-tab">
                                    @foreach ($keluhan as $key => $k)
                                        <div class="alert alert-light">
                                            <h6 class="mb-3">{{ $key }}</h6>
                                            <p class="card-text">{{ $k != '' ? $k : 'Tidak ada' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection

@push('body-scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>

    <script>
        var map = L.map('map').setView([{{ $pemeriksaan->latitude }}, {{ $pemeriksaan->longitude }}], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([{{ $pemeriksaan->latitude }}, {{ $pemeriksaan->longitude }}]).addTo(map);
    </script>

    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
            }).showToast()
        </script>
    @endif
@endpush
