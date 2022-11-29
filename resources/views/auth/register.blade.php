@extends('auth.layouts.main')


@section('content')
    <div class="auth-logo">
        <a href="/"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="height: 4rem !important"></a>
    </div>
    <h1 class="auth-title">Sign Up</h1>
    <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf
        <h5 class="mb-3">Informasi Puskesmas</h5>
        <div class="form-group position-relative has-icon-left mb-4">
            <input required type="text" class="form-control form-control-lg @error('puskesmas_admin_name') is-invalid @enderror" placeholder="Nama Admin Puskesmas" name="puskesmas_admin_name" value={{ old('puskesmas_admin_name') }}>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
            @error('puskesmas_admin_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input required type="text" class="form-control form-control-lg @error('puskesmas_name') is-invalid @enderror" placeholder="Nama Puskesmas" name="puskesmas_name" value={{ old('puskesmas_name') }}>
            <div class="form-control-icon">
                <i class="bi bi-hospital"></i>
            </div>
            @error('puskesmas_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input required type="text" class="form-control form-control-lg @error('puskesmas_head_name') is-invalid @enderror" placeholder="Nama Kepala Puskesmas" name="puskesmas_head_name" value={{ old('puskesmas_head_name') }}>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
            @error('puskesmas_head_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input required type="text" class="form-control form-control-lg @error('puskesmas_code') is-invalid @enderror" placeholder="Kode Puskesmas" name="puskesmas_code" value={{ old('puskesmas_code') }}>
            <div class="form-control-icon">
                <i class="bi bi-upc"></i>
            </div>
            @error('puskesmas_code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input required type="text" class="form-control form-control-lg @error('rt') is-invalid @enderror" placeholder="RT" name="rt" value={{ old('rt') }}>
                    <div class="form-control-icon">
                        <i class="bi bi-pin-map"></i>
                    </div>
                    @error('rt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input required type="text" class="form-control form-control-lg @error('rw') is-invalid @enderror" placeholder="RW" name="rw" value={{ old('rw') }}>
                    <div class="form-control-icon">
                        <i class="bi bi-pin-map"></i>
                    </div>
                    @error('rw')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
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

        <div class="form-group">
            <h5 class="form-label mt-5 mb-3">Alamat Lengkap Puskesmas</h5>
            <textarea name="address" value={{ old('address') }} id="address" rows="3" class="form-control @error('address') is-invalid @enderror"></textarea>
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <h5 class="mt-5 mb-3">Informasi Akun</h5>
        <div class="form-group position-relative has-icon-left mb-4">
            <input required type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" placeholder="Username" name="username" value={{ old('') }}>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input required type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password" name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input required type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Confirm Password" name="password_confirmation">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" id="submit-btn" class="btn btn-primary btn-block btn-lg shadow mt-5">Submit</button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        <p class='text-gray-600'>Already have an account? <a href="{{ route('login') }}" class="font-bold">Login</a>.</p>
    </div>
@endsection

@push('body-scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

    <script>
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
@endpush
