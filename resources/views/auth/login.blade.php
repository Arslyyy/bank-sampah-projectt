@extends('adminlte.layouts.auth')

@section('content')

<head>
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">

    <style>
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            font-family: 'Poppins', sans-serif; /* font Poppins untuk navbar */
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.1rem;
            color: #2e7d32 !important; /* hijau */
        }

        .navbar-nav img {
            transition: transform 0.2s ease-in-out;
        }

        .navbar-nav img:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="hold-transition login-page" style="background: linear-gradient(135deg, #e8f5e9, #f4f8f4);">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top w-100">
    <div class="container-fluid p-0">
        <!-- Kiri: Judul -->
        <a class="navbar-brand ms-3" href="">
            Bank Sampah Salam Lestari
        </a>

        <!-- Toggle untuk mobile -->
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Isi navbar -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav me-3 align-items-center">
                <li class="nav-item mx-2">
                    <img src="{{ asset('assets/images/LogoKemendikbud.png') }}" alt="Logo 1" height="40">
                </li>
                <li class="nav-item mx-2">
                    <img src="{{ asset('assets/images/LogoUsm.png') }}" alt="Logo 2" height="40">
                </li>
                <li class="nav-item mx-2">
                    <img src="{{ asset('assets/images/Logo.png') }}" alt="Logo 3" height="40">
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="login-box mt-4">
        <!-- Logo -->
        <div class="login-logo">
            <img src="{{ asset('assets/images/Logo.png') }}" alt="Logo Bank Sampah" width="300" class="mb-2">
        </div>
        <!-- /.login-logo -->   
        <div class="card shadow-lg" style="border-radius:12px;">
            <div class="card-body login-card-body">
                <p class="login-box-msg" style="color:#555;">Silakan login untuk melanjutkan</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" 
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-success btn-block" 
                                style="background:#2e7d32; border:none; border-radius:6px;">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- @if (Route::has('register'))
                    <p class="mb-0 mt-3 text-center">
                        <a href="{{ route('register') }}" class="text-success">{{ __('Register Akun Baru') }}</a>
                    </p>
                @endif -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
