@extends('dashboard.layouts.main')

@section('head-assets')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}"> --}}

    <style>
        .choices__inner {
            background-color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Data Posyandu Puskesmas {{ auth()->user()->puskesmas->nama_puskesmas }}</h4>
                    <a href="" class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Posyandu</a>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama Posyandu</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posyandu as $p)
                                    <tr>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td>
                                            <button class="btn icon btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $p->id }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                            <a type="button" id="btn-delete" class="btn btn-danger" data-id="{{ $p->id }}" onclick="deleteData(this.getAttribute('data-id'))">
                                                <i class="bi bi-trash"></i>
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

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('posyandu.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Posyandu Baru</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group mb-4">
                            <label class="h6">Nama Posyandu</label>
                            <input required type="text" class="form-control form-control-lg @error('nama') is-invalid @enderror" placeholder="Nama Posyandu" name="nama" value={{ old('nama') }}>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4" id="provinsi_form" style="background-color: white !important">
                            <label class="h6">Provinsi</label>
                            <select required class="form-select" id="id_provinsi" name="id_provinsi">
                                <option hidden value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('id_provinsi')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4" id="kota_form" style="background-color: white !important">
                            <label class="h6">Kota / Kabupaten</label>
                            <select required class="form-select" id="id_kota" name="id_kota">
                            </select>
                            @error('id_kota')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4" id="kecamatan_form" style="background-color: white !important">
                            <label class="h6">Kecamatan</label>
                            <select required class="form-select" id="id_kecamatan" name="id_kecamatan">
                            </select>
                            @error('id_kecamatan')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4" id="kelurahan_form" style="background-color: white !important">
                            <label class="h6">Kelurahan</label>
                            <select required class="form-select" id="id_kelurahan" name="id_kelurahan">
                            </select>
                            @error('id_kelurahan')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-4">
                                    <label class="h6">RT</label>
                                    <input required type="text" class="form-control form-control-lg @error('rt') is-invalid @enderror" placeholder="RT" name="rt" value={{ old('rt') }}>
                                    @error('rt')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-4">
                                    <label class="h6">RW</label>
                                    <input required type="text" class="form-control form-control-lg @error('rw') is-invalid @enderror" placeholder="RW" name="rw" value={{ old('rw') }}>
                                    @error('rw')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="h6">Alamat Lengkap</label>
                            <textarea required name="alamat" value={{ old('alamat') }} id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat Lengkap Posyandu"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Posyandu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Posyandu</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <small class="text-muted">Nama Posyandu</small> <br>
                        <h5 id="nama">...</h5>
                    </div>

                    <div class="form-group mb-3">
                        <small class="text-muted">Alamat Posyandu</small> <br>
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
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script> --}}

    @if (!$errors->isEmpty())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('addModal'), {
                keyboard: false
            })

            myModal.show()

            console.log('{{ $errors }}')
        </script>
    @endif

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
        function deleteData(id) {
            console.log(id)

            Swal.fire({
                title: 'Yakin Hapus Posyandu?',
                text: "Posyandu yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Posyandu'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/posyandu/' + id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        complete: function() {
                            location.reload();
                        }
                    })

                }
            })
        }

        let choices = document.querySelectorAll(".choices")
        let initChoice
        for (let i = 0; i < choices.length; i++) {
            if (choices[i].classList.contains("multiple-remove")) {
                initChoice = new Choices(choices[i], {
                    delimiter: ",",
                    editItems: true,
                    maxItemCount: -1,
                    removeItemButton: true,
                })
            } else {
                initChoice = new Choices(choices[i])
            }
        }

        $(document).on('change', '#id_provinsi', function() {
            var provinsiID = $(this).val();
            console.log(provinsiID)
            if (provinsiID) {
                $.ajax({
                    url: '/getCities/' + provinsiID,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#id_kota').empty();
                            $('#id_kota').append('<option hidden value="">Pilih Kabupaten / Kota</option>');
                            $.each(data, function(key, item) {
                                $('#id_kota').append('<option value="' + item.id + '">' + item.name + '</option>');
                            });
                        } else {
                            $('#id_kota').empty();
                        }
                    }
                });
            } else {
                $('#id_kota').empty();
            }
        });

        $(document).on('change', '#id_kota', function() {
            var kabID = $(this).val();
            if (kabID) {
                $.ajax({
                    url: '/getDistricts/' + kabID,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#id_kecamatan').empty();
                            $('#id_kecamatan').append('<option hidden value="">Pilih Kecamatan</option>');
                            $.each(data, function(key, item) {
                                console.log(item.name)
                                $('#id_kecamatan').append('<option value="' + item.id + '">' + item.name + '</option>');
                            });
                        } else {
                            $('#id_kecamatan').empty();
                        }
                    }
                });
            } else {
                $('#id_kecamatan').empty();
            }
        });

        $(document).on('change', '#id_kecamatan', function() {
            var kecamatanID = $(this).val();
            if (kecamatanID) {
                $.ajax({
                    url: '/getVillages/' + kecamatanID,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#id_kelurahan').empty();
                            $('#id_kelurahan').append('<option hidden value="">Pilih Kelurahan</option>');
                            $.each(data, function(key, item) {
                                $('#id_kelurahan').append('<option value="' + item.id + '">' + item.name + '</option>');
                            });
                        } else {
                            $('#id_kelurahan').empty();
                        }
                    }
                });
            } else {
                $('#id_kelurahan').empty();
            }
        });
    </script>

    <script>
        $('#detailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)

            $.ajax({
                url: "{{ url('') }}" + '/posyandu/' + button.data('id'),
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    var data = response;
                    modal.find('.modal-body #nama').html(data['nama'])
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
