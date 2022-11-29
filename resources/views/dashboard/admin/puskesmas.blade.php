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
                    <h4 class="card-title">Data User Puskesmas</h4>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama Puskesmas</th>
                                    <th>Kode Puskesmas</th>
                                    <th>Kepala Puskesmas</th>
                                    <th>Admin Puskesmas</th>
                                    <th>Status Validasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($puskesmas as $p)
                                    <tr>
                                        <td>{{ $p->nama_puskesmas }}</td>
                                        <td>{{ $p->kode_puskesmas }}</td>
                                        <td>{{ $p->kepala_puskesmas }}</td>
                                        <td>{{ $p->nama_admin }}</td>
                                        <td>
                                            @if (isset($p->verified_at))
                                                <span class="badge bg-success">Tervalidasi</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Valid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn icon btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $p->id }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                            @if (isset($p->verified_at))
                                                <a href="{{ route('removeValidationPuskesmas', $p->id) }}" class="btn icon btn-danger">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('validatingPuskesmas', $p->id) }}" class="btn icon btn-success">
                                                    <i class="bi bi-check"></i>
                                                </a>
                                            @endif
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
                    <h5 class="modal-title" id="exampleModalLabel">Detail Puskesmas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <small class="text-muted">Nama Puskesmas</small> <br>
                        <h5 id="nama_puskesmas">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Kode Puskesmas</small> <br>
                        <h5 id="kode_puskesmas">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Kepala Puskesmas</small> <br>
                        <h5 id="kepala_puskesmas">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Nama Admin Puskesmas</small> <br>
                        <h5 id="nama_admin">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Alamat Puskesmas</small> <br>
                        <h5 id="alamat">...</h5>
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
        let jquery_datatable = $("#table1").DataTable()
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
                url: "{{ url('') }}" + '/puskesmas/' + button.data('id'),
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    var data = response;
                    modal.find('.modal-body #nama_puskesmas').html(data['nama_puskesmas'])
                    modal.find('.modal-body #kode_puskesmas').html(data['kode_puskesmas'])
                    modal.find('.modal-body #kepala_puskesmas').html(data['kepala_puskesmas'])
                    modal.find('.modal-body #nama_admin').html(data['nama_admin'])
                    modal.find('.modal-body #alamat').html(data['alamat'])
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
    </script>
@endpush
