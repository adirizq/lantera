@extends('dashboard.layouts.main')

@section('head-assets')
    <link rel="stylesheet" href="assets/css/shared/iconly.css">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />


    <style>
        #map {
            height: 600px;
            width: 100%;
        }
    </style>
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
                                        <h6 class="text-muted font-semibold">Total Posyandu</h6>
                                        <h6 class="font-extrabold mb-0">{{ $posyandu_count }}</h6>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Lansia dengan Gangguan Kesehatan</h4>
                            </div>
                            <div class="card-body">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Nama Lansia</th>
                                            <th>Posyandu</th>
                                            <th>Alamat</th>
                                            <th>Jenis Gangguan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ldg as $lansia)
                                            <tr>
                                                <td>{{ $lansia->nama }}</td>
                                                <td>{{ $lansia->nama_posyandu }}</td>
                                                <td>{{ $lansia->alamat_domisili }}</td>
                                                <td>{!! find_gangguan($lansia->status_malnutrisi, $lansia->status_penglihatan, $lansia->status_pendengaran, $lansia->status_mobilitas, $lansia->status_kognitif, $lansia->status_gejala_depresi) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Pemeriksaan Tahun {{ now()->year }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-pemeriksaan-per-tahun"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Pemeriksaan Bulan {{ now()->translatedFormat('F') }} {{ now()->year }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-pemeriksaan-per-bulan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Peta Persebaran Lansia</h4>
                            </div>
                            <div class="card-body">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Persentase Kondisi Malnutrisi Lansia</h4>
                            </div>
                            <div class="card-body px-4 py-4">
                                <div id="chart-malnutrisi"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Persentase Kondisi Penglihatan Lansia</h4>
                            </div>
                            <div class="card-body px-4 py-4">
                                <div id="chart-penglihatan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Persentase Kondisi Pendengaran Lansia</h4>
                            </div>
                            <div class="card-body px-4 py-4">
                                <div id="chart-pendengaran"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Persentase Kondisi Mobilitas Lansia</h4>
                            </div>
                            <div class="card-body px-4 py-4">
                                <div id="chart-mobilitas"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Persentase Kondisi Kognitif Lansia</h4>
                            </div>
                            <div class="card-body px-4 py-4">
                                <div id="chart-kognitif"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Persentase Kondisi Gejala Depresi Lansia</h4>
                            </div>
                            <div class="card-body px-4 py-4">
                                <div id="chart-gejala_depresi"></div>
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
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script>
        //Lansia dengan gangguan kesehatan
        let jquery_datatable = $("#table1").DataTable({
            "order": [],
            "columnDefs": [{
                "width": "500px",
                "targets": 3
            }, ]
        })



        //Data pemeriksaan
        var optionsDataPemeriksaanPerTahun = {
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
                name: "Pemeriksaan",
                data: @json($ppt),
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

        var optionsDataPemeriksaanPerBulan = {
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
                name: "Pemeriksaan",
                data: @json($ppb),
            }, ],
            colors: "#6c9886",
            xaxis: {
                categories: Array({{ $total_days }}).fill(1).map((n, i) => n + i),
            },
        }


        var chartDataPemeriksaanPerTahun = new ApexCharts(
            document.querySelector("#chart-pemeriksaan-per-tahun"),
            optionsDataPemeriksaanPerTahun
        )
        chartDataPemeriksaanPerTahun.render()


        var chartDataPemeriksaanPerBulan = new ApexCharts(
            document.querySelector("#chart-pemeriksaan-per-bulan"),
            optionsDataPemeriksaanPerBulan
        )
        chartDataPemeriksaanPerBulan.render()



        //Peta persebaran lansia
        var locations = @json($lokasi_lansia);

        var map = L.map('map').setView([{{ $lokasi_lansia[0]['latitude'] }}, {{ $lokasi_lansia[0]['longitude'] }}], 13);

        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        for (var i = 0; i < locations.length; i++) {
            marker = new L.marker([locations[i]['latitude'], locations[i]['longitude']])
                .bindPopup(locations[i]['nama'])
                .addTo(map);
        }

        Apex.colors = ['#198754', '#ffc107', '#dc3545']

        //Data per kategori kesehatan
        pieChart("#chart-malnutrisi", @json($data_malnutrisi))
        pieChart("#chart-penglihatan", @json($data_penglihatan))
        pieChart("#chart-pendengaran", @json($data_pendengaran))
        pieChart("#chart-mobilitas", @json($data_mobilitas))
        pieChart("#chart-kognitif", @json($data_kognitif))
        pieChart("#chart-gejala_depresi", @json($data_gejala_depresi))

        function pieChart(id, data) {
            var options = {
                series: data,
                labels: ['Normal', 'Berisiko', 'Gangguan'],
                chart: {
                    type: 'donut'
                },
                plotOptions: {
                    pie: {
                        expandOnClick: false
                    }
                },
            }

            var chart = new ApexCharts(
                document.querySelector(id),
                options
            )
            chart.render()
        }
    </script>
@endpush
