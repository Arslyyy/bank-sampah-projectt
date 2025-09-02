@extends('adminlte.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-gradient"
                            style="background: linear-gradient(45deg, #fd7e14, #dc3545); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                            <i class="fas fa-{{ $data ? 'user-edit' : 'user-plus' }} mr-2"></i>
                            @if ($data)
                                Edit
                            @else
                                Tambah
                            @endif Nasabah
                        </h1>
                        <p class="text-muted mb-0">
                            {{ $data ? 'Perbarui informasi data nasabah' : 'Tambahkan nasabah baru ke sistem' }}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                            <li class="breadcrumb-item">
                                <a href="/manajemen/nasabah" class="text-orange">
                                    <i class="fas fa-users"></i> Nasabah
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-secondary">
                                @if ($data)
                                    Edit
                                @else
                                    Create
                                @endif Nasabah
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!-- Form Card -->
                    <div class="col-lg-8 col-md-10">
                        <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                            <!-- Card Header with Gradient -->
                            <div class="card-header bg-gradient-orange text-white"
                                style="border-radius: 0; padding: 1.5rem;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-25 rounded-circle p-3 mr-3">
                                        <i class="fas fa-{{ $data ? 'user-edit' : 'user-plus' }} fa-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title mb-1">
                                            Form {{ $data ? 'Edit' : 'Tambah' }} Nasabah
                                        </h3>
                                        <p class="mb-0 opacity-75">
                                            {{ $data ? 'Ubah data nasabah yang sudah terdaftar' : 'Daftarkan nasabah baru ke sistem bank sampah' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Body -->
                            <form class="form-horizontal"
                                action="{{ request()->is('admin/manajemen/nasabah/create') ? url('admin/manajemen/nasabah/store') : url('admin/manajemen/nasabah/update', $data->id) }}"
                                method="POST" enctype="multipart/form-data" id="nasabahForm">
                                @csrf
                                @if ($data)
                                    @method('PUT')
                                @else
                                    @method('POST')
                                @endif

                                <div class="card-body" style="padding: 2rem;">
                                    <!-- Progress Indicator -->
                                    <div class="progress-container mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge badge-orange px-3 py-2">
                                                <i class="fas fa-user-check mr-1"></i>
                                                Formulir Nasabah
                                            </span>
                                            <small class="text-muted">Isi semua field yang diperlukan</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-orange" role="progressbar"
                                                style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Profile Section Header -->
                                    <div class="section-header mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-orange text-white rounded-circle p-2 mr-3">
                                                <i class="fas fa-address-card"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1 font-weight-bold text-orange">Informasi Personal</h5>
                                                <small class="text-muted">Data pribadi nasabah bank sampah</small>
                                            </div>
                                        </div>
                                        <hr class="mt-3 mb-4">
                                    </div>

                                    <!-- Nama Field -->
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-user text-orange mr-2"></i>
                                            Nama Lengkap
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-id-card text-orange"></i>
                                                </span>
                                            </div>
                                            <input type="text"
                                                class="form-control border-left-0 @error('nama') is-invalid @enderror"
                                                name="nama" id="nama"
                                                value="{{ old('nama', $data ? $data->nama : '') }}"
                                                placeholder="Masukkan nama lengkap nasabah"
                                                onkeyup="updateProgress(); validateName(this);" maxlength="100">
                                        </div>
                                        @error('nama')
                                            <div class="alert alert-danger mt-2 border-0" style="border-radius: 10px;">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-feedback mt-2">
                                            <div class="d-flex justify-content-between">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Masukkan nama lengkap sesuai identitas
                                                </small>
                                                <small class="text-muted">
                                                    <span id="namaCount">0</span>/100
                                                </small>
                                            </div>
                                            <div id="namaValidation" class="mt-1" style="display: none;">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Nama valid
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Alamat Field -->
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-map-marker-alt text-orange mr-2"></i>
                                            Alamat Lengkap
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="position-relative">
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" rows="4"
                                                placeholder="Masukkan alamat lengkap nasabah (termasuk RT/RW, Kelurahan, Kecamatan)"
                                                onkeyup="updateProgress(); autoResize(this);" maxlength="500" style="resize: none; padding-left: 3rem;">{{ old('alamat', $data ? $data->alamat : '') }}</textarea>
                                            <div class="position-absolute" style="left: 12px; top: 12px;">
                                                <i class="fas fa-home text-orange"></i>
                                            </div>
                                        </div>
                                        @error('alamat')
                                            <div class="alert alert-danger mt-2 border-0" style="border-radius: 10px;">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-feedback mt-2">
                                            <div class="d-flex justify-content-between">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Sertakan detail jalan, RT/RW, kelurahan, dan kecamatan
                                                </small>
                                                <small class="text-muted">
                                                    <span id="alamatCount">0</span>/500
                                                </small>
                                            </div>
                                            <div class="mt-2">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <small class="text-muted">
                                                            <i class="fas fa-road mr-1"></i>Jalan/Gang
                                                        </small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small class="text-muted">
                                                            <i class="fas fa-home mr-1"></i>RT/RW
                                                        </small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small class="text-muted">
                                                            <i class="fas fa-building mr-1"></i>Kelurahan
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preview Card -->
                                    <div class="preview-card bg-light rounded p-4 mb-4" id="previewCard"
                                        style="display: none; border-left: 4px solid #fd7e14;">
                                        <h6 class="font-weight-bold text-orange mb-3">
                                            <i class="fas fa-eye mr-2"></i>Preview Data Nasabah
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="preview-item mb-3">
                                                    <small class="text-muted d-block">Nama Lengkap:</small>
                                                    <div class="font-weight-bold" id="previewNama">-</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="preview-item mb-3">
                                                    <small class="text-muted d-block">Status:</small>
                                                    <span class="badge badge-success" id="previewStatus">
                                                        <i
                                                            class="fas fa-user-check mr-1"></i>{{ $data ? 'Nasabah Terdaftar' : 'Nasabah Baru' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="preview-item">
                                                    <small class="text-muted d-block">Alamat:</small>
                                                    <div class="font-weight-medium" id="previewAlamat">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-envelope text-orange mr-2"></i>
                                            Email
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-at text-orange"></i>
                                                </span>
                                            </div>
                                            <input type="email"
                                            class="form-control border-left-0 @error('email') is-invalid @enderror"
                                            name="email" id="email"
                                            value="{{ old('email', $data->user->email ?? '') }}"
                                            placeholder="Masukkan email nasabah">
                                        </div>
                                        @error('email')
                                            <div class="alert alert-danger mt-2 border-0" style="border-radius: 10px;">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-lock text-orange mr-2"></i>
                                            Password
                                            @if(!$data)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-key text-orange"></i>
                                                </span>
                                            </div>
                                            <input type="password"
                                                class="form-control border-left-0 @error('password') is-invalid @enderror"
                                                name="password" id="password"
                                                placeholder="{{ $data ? 'Kosongkan jika tidak ingin diubah' : 'Masukkan password nasabah' }}">
                                        </div>
                                        @error('password')
                                            <div class="alert alert-danger mt-2 border-0" style="border-radius: 10px;">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <!-- Additional Info -->
                                    <div class="alert alert-info border-0" style="border-radius: 10px;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-lightbulb fa-2x text-info mr-3"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1">Tips Pengisian Form</h6>
                                                <p class="mb-0 small">
                                                    Pastikan data yang dimasukkan akurat dan sesuai dengan identitas nasabah
                                                    untuk memudahkan proses transaksi bank sampah.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Footer -->
                                <div class="card-footer bg-light" style="padding: 1.5rem 2rem;">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt mr-1"></i>
                                                Data nasabah akan disimpan dengan aman
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-end">
                                                <a href="/admin/manajemen/nasabah"
                                                    class="btn btn-outline-secondary rounded-pill mr-2 px-4">
                                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                                </a>
                                                <button type="submit" class="btn btn-orange rounded-pill px-4 shadow-sm"
                                                    id="submitBtn" disabled>
                                                    <i class="fas fa-{{ $data ? 'save' : 'user-plus' }} mr-2"></i>
                                                    {{ $data ? 'PERBARUI' : 'DAFTARKAN' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                            <div class="card-header bg-gradient-orange text-white" style="border-radius: 15px 15px 0 0;">
                                <h6 class="mb-0">
                                    <i class="fas fa-question-circle mr-2"></i>Panduan Pendaftaran
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="help-item mb-3">
                                    <h6 class="font-weight-bold text-orange">
                                        <i class="fas fa-user mr-2"></i>Nama Lengkap
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Masukkan nama lengkap sesuai dengan KTP atau identitas resmi lainnya.
                                    </p>
                                </div>
                                <div class="help-item mb-3">
                                    <h6 class="font-weight-bold text-orange">
                                        <i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Sertakan informasi detail alamat termasuk RT/RW, kelurahan, dan kecamatan untuk
                                        memudahkan pengantaran.
                                    </p>
                                </div>
                                <div class="help-item">
                                    <h6 class="font-weight-bold text-orange">
                                        <i class="fas fa-check-circle mr-2"></i>Verifikasi Data
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Periksa kembali data yang dimasukkan sebelum menyimpan untuk menghindari kesalahan.
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-center">
                                <small class="text-muted">
                                    <i class="fas fa-phone mr-1"></i>
                                    Butuh bantuan? Hubungi admin
                                </small>
                            </div>
                        </div>

                        <!-- Benefits Card -->
                        <div class="card border-0 shadow-sm mt-3" style="border-radius: 15px;">
                            <div class="card-header bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                                <h6 class="mb-0">
                                    <i class="fas fa-star mr-2"></i>Keuntungan Menjadi Nasabah
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="benefit-item d-flex align-items-center mb-2">
                                    <i class="fas fa-money-bill-alt text-success mr-3"></i>
                                    <small>Dapatkan uang dari sampah</small>
                                </div>
                                <div class="benefit-item d-flex align-items-center mb-2">
                                    <i class="fas fa-leaf text-success mr-3"></i>
                                    <small>Berkontribusi untuk lingkungan</small>
                                </div>
                                <div class="benefit-item d-flex align-items-center mb-2">
                                    <i class="fas fa-users text-success mr-3"></i>
                                    <small>Bergabung dengan komunitas</small>
                                </div>
                                <div class="benefit-item d-flex align-items-center">
                                    <i class="fas fa-recycle text-success mr-3"></i>
                                    <small>Membantu daur ulang sampah</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Custom CSS -->
    <style>
        .text-gradient {
            font-size: 1.8rem;
        }

        .bg-gradient-orange {
            background: linear-gradient(87deg, #fd7e14 0, #dc3545 100%) !important;
        }

        .bg-orange {
            background-color: #fd7e14 !important;
        }

        .btn-orange {
            background-color: #fd7e14;
            border-color: #fd7e14;
            color: white;
        }

        .btn-orange:hover {
            background-color: #e8690b;
            border-color: #e8690b;
            color: white;
        }

        .text-orange {
            color: #fd7e14 !important;
        }

        .badge-orange {
            background-color: #fd7e14;
            color: white;
        }

        .bg-opacity-25 {
            background-color: rgba(255, 255, 255, 0.25) !important;
        }

        .preview-item {
            margin-bottom: 1rem;
        }

        .help-item {
            border-left: 3px solid #e9ecef;
            padding-left: 1rem;
        }

        .section-header {
            position: relative;
        }

        .form-control:focus,
        .custom-select:focus {
            border-color: #fd7e14;
            box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
        }

        .input-group-text {
            border: 1px solid #ced4da;
        }

        .card {
            transition: all 0.3s ease;
        }

        .preview-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        textarea {
            transition: height 0.3s ease;
        }

        @media (max-width: 768px) {
            .text-gradient {
                font-size: 1.4rem;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .card-footer {
                padding: 1rem !important;
            }

            .d-flex.justify-content-end {
                flex-direction: column;
            }

            .d-flex.justify-content-end .btn {
                margin: 0.25rem 0 !important;
            }
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        $(document).ready(function() {
            // Initialize form
            updateProgress();
            updatePreview();
            updateCharacterCounts();

            // Add smooth animations
            $('.card').hide().fadeIn(800);
        });

        // Auto resize textarea
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
            updateCharacterCounts();
        }

        // Update character counts
        function updateCharacterCounts() {
            const nama = $('#nama').val();
            const alamat = $('#alamat').val();

            $('#namaCount').text(nama.length);
            $('#alamatCount').text(alamat.length);
        }

        // Validate name
        function validateName(input) {
            const name = input.value.trim();
            const validation = $('#namaValidation');

            if (name.length >= 3) {
                validation.show();
                validation.html('<small class="text-success"><i class="fas fa-check-circle mr-1"></i>Nama valid</small>');
            } else if (name.length > 0) {
                validation.show();
                validation.html(
                    '<small class="text-warning"><i class="fas fa-exclamation-circle mr-1"></i>Nama terlalu pendek</small>'
                    );
            } else {
                validation.hide();
            }

            updateCharacterCounts();
        }

        // Update progress bar
        function updateProgress() {
            let filledFields = 0;
            let totalFields = 2;

            // Check nama
            if ($('#nama').val().trim().length >= 3) filledFields++;

            // Check alamat
            if ($('#alamat').val().trim().length >= 10) filledFields++;

            let progress = (filledFields / totalFields) * 100;
            $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);

            // Enable/disable submit button
            if (progress === 100) {
                $('#submitBtn').prop('disabled', false);
                $('.badge-orange').removeClass('badge-warning').addClass('badge-success');
                $('.badge').html('<i class="fas fa-check-circle mr-1"></i>Form Lengkap');
            } else {
                $('#submitBtn').prop('disabled', true);
                $('.badge').removeClass('badge-success').addClass('badge-orange');
                $('.badge').html('<i class="fas fa-user-check mr-1"></i>Formulir Nasabah');
            }

            updatePreview();
        }

        // Update preview
        function updatePreview() {
            let nama = $('#nama').val().trim();
            let alamat = $('#alamat').val().trim();

            $('#previewNama').text(nama || '-');
            $('#previewAlamat').text(alamat || '-');

            // Show/hide preview card
            if (nama || alamat) {
                $('#previewCard').slideDown();
            } else {
                $('#previewCard').slideUp();
            }
        }

        // Reset form
        function resetForm() {
            $('#previewCard').slideUp();
            $('.progress-bar').css('width', '25%').attr('aria-valuenow', 25);
            $('.badge').removeClass('badge-success').addClass('badge-orange').html(
                '<i class="fas fa-user-check mr-1"></i>Formulir Nasabah');
            $('#submitBtn').prop('disabled', true);
            $('#namaValidation').hide();

            // Reset textareas
            $('textarea').each(function() {
                this.style.height = 'auto';
            });

            setTimeout(() => {
                updateProgress();
                updateCharacterCounts();
            }, 100);
        }

        // Form validation
        $('#nasabahForm').on('submit', function(e) {
            let isValid = true;
            let errors = [];

            const nama = $('#nama').val().trim();
            const alamat = $('#alamat').val().trim();

            if (nama.length < 3) {
                errors.push('Nama harus minimal 3 karakter');
                isValid = false;
            }

            if (alamat.length < 10) {
                errors.push('Alamat harus minimal 10 karakter');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Harap perbaiki kesalahan berikut:\n' + errors.join('\n'));
            } else {
                // Show loading state
                $('#submitBtn').html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
                $('#submitBtn').prop('disabled', true);
            }
        });

        // Add event listeners
        $('#nama').on('input', function() {
            updateProgress();
            validateName(this);
        });

        $('#alamat').on('input', function() {
            updateProgress();
            autoResize(this);
        });

        // Initialize textarea auto-resize
        $('textarea').each(function() {
            autoResize(this);
        });
    </script>
@endsection
