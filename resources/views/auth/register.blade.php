@extends('adminlte.layouts.auth')

@section('content')

<head>
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo.png') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e8f5e9, #f4f8f4);
        }

        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.1rem;
            color: #2e7d32 !important;
        }

        .nav-link {
            font-weight: 500;
            color: #2e7d32 !important;
            transition: color 0.2s ease-in-out;
        }

        .nav-link:hover {
            color: #1b5e20 !important;
        }

        .navbar-nav img {
            transition: transform 0.2s ease-in-out;
        }

        .navbar-nav img:hover {
            transform: scale(1.1);
        }

        .register-box {
            margin-top: 70px; /* supaya tidak ketutup navbar */
        }
    </style>
</head>

<body class="hold-transition register-page">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid p-0">
            <!-- Kiri: Judul -->
            <a class="navbar-brand ms-3" href="#">
                Bank Sampah Salam Lestari
            </a>

            <!-- Toggle untuk mobile -->
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" 
                    aria-label="Toggle navigation">
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
    <!-- End Navbar -->

    <!-- Register Box -->
    <div class="register-box">
        <!-- Logo -->
        <div class="register-logo">
            <img src="{{ asset('assets/images/Logo.png') }}" alt="Logo Bank Sampah" width="250" class="mb-2">
        </div>

        <div class="card shadow-lg" style="border-radius:12px;">
            <div class="card-body register-card-body">
                <p class="login-box-msg" style="color:#555; font-weight:500;">Buat akun baru</p>

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <!-- Nama -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" 
                               name="password_confirmation" placeholder="Ulangi Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                                <label for="agreeTerms">
                                    Saya setuju dengan <a href="#">syarat & ketentuan</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-success btn-block" 
                                    style="background:#2e7d32; border:none; border-radius:6px;">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>

                @if (Route::has('login'))
                    <p class="mb-0 mt-3 text-center">
                        <a href="{{ route('login') }}" class="text-success">Sudah punya akun? Login</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</body>
@endsection
