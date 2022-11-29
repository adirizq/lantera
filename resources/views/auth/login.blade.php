@extends('auth.layouts.main')

@section('content')
    <div class="auth-logo">
        <a href="/"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="height: 4rem !important"></a>
    </div>
    <h1 class="auth-title">Log in.</h1>
    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl @error('username') is-invalid @enderror" placeholder="Username" name="username">
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
            <input type="password" class="form-control form-control-xl @error('username') is-invalid @enderror" placeholder="Password" name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <div class="form-check form-check-lg d-flex align-items-end">
            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                Keep me logged in
            </label>
        </div> --}}
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Log in</button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold">Signup</a>.</p>
        <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
    </div>

    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: "error",
                title: "{{ session('error') }}",
            })
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "{{ session('success') }}",
            })
        </script>
    @endif
@endsection
