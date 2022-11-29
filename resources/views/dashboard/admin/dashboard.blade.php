@extends('dashboard.layouts.main')

@section('head-assets')
    <link rel="stylesheet" href="assets/css/shared/iconly.css">
@endsection

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4">
                                <div class="row">
                                    <div class="col-md-4 col-xxl-3 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-sm-2 mb-md-0 mb-xxl-0">
                                            <i class="iconly-boldHome"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xxl-9">
                                        <h6 class="text-muted font-semibold">Total Puskesmas</h6>
                                        <h6 class="font-extrabold mb-0">{{ $puskesmas_count }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4">
                                <div class="row">
                                    <div class="col-md-4 col-xxl-3 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-sm-2 mb-md-0 mb-xxl-0">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xxl-9">
                                        <h6 class="text-muted font-semibold">Total Kader</h6>
                                        <h6 class="font-extrabold mb-0">{{ $kader_count }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4">
                                <div class="row">
                                    <div class="col-md-4 col-xxl-3 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-sm-2 mb-md-0 mb-xxl-0">
                                            <i class="iconly-boldHeart"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xxl-9">
                                        <h6 class="text-muted font-semibold">Total Lansia</h6>
                                        <h6 class="font-extrabold mb-0">{{ $lansia_count }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4">
                                <div class="row">
                                    <div class="col-md-4 col-xxl-3 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-sm-2 mb-md-0 mb-xxl-0">
                                            <i class="iconly-boldDocument"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xxl-9">
                                        <h6 class="text-muted font-semibold">Total Pemeriksaan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $pemeriksaan_count }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Chart Data Pemeriksaan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-data-pemeriksaan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Persetase Kader per Puskesmas</h4>
                            </div>
                            <div class="card-body p-5">
                                <div id="chart-kader-puskesmas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('body-scripts')
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script>
        var optionsDataPemeriksaan = {
            annotations: {
                position: "back",
            },
            dataLabels: {
                enabled: false,
            },
            chart: {
                type: "bar",
                height: 300,
            },
            fill: {
                opacity: 1,
            },
            plotOptions: {},
            series: [{
                name: "sales",
                data: [{{ $pbm[0] }}, {{ $pbm[1] }}, {{ $pbm[2] }}, {{ $pbm[3] }}, {{ $pbm[4] }}, {{ $pbm[5] }}, {{ $pbm[6] }}, {{ $pbm[7] }}, {{ $pbm[8] }}, {{ $pbm[9] }}, {{ $pbm[10] }}, {{ $pbm[11] }}],
            }, ],
            colors: "#6c9886",
            xaxis: {
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
            },
        }


        var chartDataPemeriksaan = new ApexCharts(
            document.querySelector("#chart-data-pemeriksaan"),
            optionsDataPemeriksaan
        )

        chartDataPemeriksaan.render()


        var optionsKaderPuskesmas = {
            series: [{{ $kbp_d }}],
            labels: [{!! $kbp_p !!}],
            chart: {
                type: 'donut'
            }
        }

        var chartKaderPuskesmas = new ApexCharts(
            document.querySelector("#chart-kader-puskesmas"),
            optionsKaderPuskesmas
        )

        chartKaderPuskesmas.render()
    </script>
@endpush
