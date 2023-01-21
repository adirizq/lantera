@extends('dashboard.layouts.main')

@section('head-assets')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endsection

@section('content')
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Pemeriksaan Puskesmas</h4>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>ID Pemeriksaan</th>
                                    <th>Nama Lansia</th>
                                    <th>Nama Kader</th>
                                    <th>Waktu Pemeriksaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemeriksaan as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>{{ $p->lansia->nama }}</td>
                                        <td>{{ $p->kader->nama }}</td>
                                        <td>{{ $p->created_at }}</td>
                                        <td>
                                            <a href="{{ route('pemeriksaan.show', $p->id) }}" class="btn icon btn-info">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

    <script>
        let jquery_datatable = $("#table1").DataTable({
            "order": [],
            "columnDefs": [{
                "width": "50px",
                "targets": 4
            }, ]
        })
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
