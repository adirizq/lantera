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
                    <h4 class="card-title">Data Lansia Puskesmas</h4>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama Lansia</th>
                                    <th>Posyandu</th>
                                    <th>No KTP</th>
                                    <th>Alamat Domisili</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lansia as $l)
                                    <tr>
                                        <td>{{ $l->nama }}</td>
                                        <td>{{ $l->posyandu->nama }}</td>
                                        <td>{{ $l->no_ktp }}</td>
                                        <td>{{ $l->alamat_domisili }}</td>
                                        <td>
                                            <button class="btn icon btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $l->id }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
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

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Lansia</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <small class="text-muted">Nama Lansia</small> <br>
                        <h5 id="nama">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">No KTP</small> <br>
                        <h5 id="no_ktp">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">No KK</small> <br>
                        <h5 id="no_kk">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Tanggal Lahir</small> <br>
                        <h5 id="tgl_lahir">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Posyandu</small> <br>
                        <h5 id="posyandu">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Pekerjaan</small> <br>
                        <h5 id="pekerjaan">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Alamat Domisili</small> <br>
                        <h5 id="alamat_domisili">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Alamat KTP</small> <br>
                        <h5 id="alamat_ktp">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">RT / RW</small> <br>
                        <h5 id="rt_rw">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Provinsi</small> <br>
                        <h5 id="provinsi">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Kota</small> <br>
                        <h5 id="kota">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Kecamatan</small> <br>
                        <h5 id="kecamatan">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Kelurahan</small> <br>
                        <h5 id="kelurahan">...</h5>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
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
                    "width": "150px",
                    "targets": 2
                }, {
                    "width": "25%",
                    "targets": 3
                },
                {
                    "width": "50px",
                    "targets": 4
                },
            ]
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

    <script>
        $('#detailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)

            $.ajax({
                url: "{{ url('') }}" + '/lansia/' + button.data('id'),
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    var data = response;
                    modal.find('.modal-body #nama').html(data['nama'])
                    modal.find('.modal-body #no_ktp').html(data['no_ktp'])
                    modal.find('.modal-body #no_kk').html(data['no_kk'])
                    modal.find('.modal-body #tgl_lahir').html(data['tgl_lahir'])
                    modal.find('.modal-body #posyandu').html(data['posyandu'].nama)
                    modal.find('.modal-body #pekerjaan').html(check(data['pekerjaan']))
                    modal.find('.modal-body #alamat_domisili').html(data['alamat_domisili'])
                    modal.find('.modal-body #alamat_ktp').html(data['alamat_ktp'])
                    modal.find('.modal-body #rt_rw').html(data['rt'] + ' / ' + data['rw'])
                    modal.find('.modal-body #provinsi').html(data['provinsi'])
                    modal.find('.modal-body #kota').html(data['kota'])
                    modal.find('.modal-body #kecamatan').html(data['kecamatan'])
                    modal.find('.modal-body #kelurahan').html(data['kelurahan'])
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        })

        function check(val) {
            if (val == null) {
                return '[No Data]';
            } else {
                return val;
            }
        }
    </script>
@endpush
