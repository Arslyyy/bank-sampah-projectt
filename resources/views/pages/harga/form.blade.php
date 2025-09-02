@extends('adminlte.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-gradient"
                            style="background: linear-gradient(45deg, #28a745, #17a2b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                            <i class="fas fa-{{ $data ? 'edit' : 'plus-circle' }} mr-2"></i>
                            @if ($data)
                                Edit
                            @else
                                Tambah
                            @endif Harga Sampah
                        </h1>
                        <p class="text-muted mb-0">
                            {{ $data ? 'Perbarui informasi harga sampah' : 'Tambahkan harga sampah baru ke sistem' }}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                            <li class="breadcrumb-item">
                                <a href="/bank/harga" class="text-success">
                                    <i class="fas fa-tags"></i> Harga Sampah
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-secondary">
                                @if ($data)
                                    Edit
                                @else
                                    Create
                                @endif Harga
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
                            <div class="card-header bg-gradient-success text-white"
                                style="border-radius: 0; padding: 1.5rem;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-25 rounded-circle p-3 mr-3">
                                        <i class="fas fa-{{ $data ? 'edit' : 'plus' }} fa-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title mb-1">
                                            Form {{ $data ? 'Edit' : 'Tambah' }} Harga Sampah
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Body -->
                            <form class="form-horizontal"
                                action="{{ request()->is('admin/bank/harga/create') ? url('admin/bank/harga/store') : url('admin/bank/harga/update', $data->id) }}"
                                method="POST" enctype="multipart/form-data" id="hargaForm">
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
                                            <span class="badge badge-info px-3 py-2">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Langkah 1 dari 3
                                            </span>
                                            <small class="text-muted">Isi semua field yang diperlukan</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Jenis Sampah Field -->
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-recycle text-success mr-2"></i>
                                            Jenis / Type Sampah
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-list-alt text-success"></i>
                                                </span>
                                            </div>
                                            <select
                                                class="form-control custom-select border-left-0 @error('id_master_jenis_sampah') is-invalid @enderror"
                                                name="id_master_jenis_sampah" id="jenisSampah" onchange="updateProgress()">
                                                <option value="" selected>-- Pilih Jenis Sampah --</option>
                                                @forelse ($j_sampah as $val)
                                                    <option value="{{ $val->id }}"
                                                        {{ $data ? ($val->id == $data->id_master_jenis_sampah ? 'selected' : '') : '' }}>
                                                        {{ $val->type_sampah }}
                                                    </option>
                                                @empty
                                                    <option value="">Tidak ada data</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        @error('id_master_jenis_sampah')
                                            <div class="alert alert-danger mt-2 border-0" style="border-radius: 10px;">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Pilih jenis sampah yang akan ditentukan harganya
                                        </small>
                                    </div>

                                    <!-- Harga dan Satuan Row -->
                                    <div class="row">
                                        <!-- Harga Sampah Field -->
                                        <div class="col-lg-8">
                                            <div class="form-group mb-4">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-money-bill-wave text-warning mr-2"></i>
                                                    Harga Sampah
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light border-right-0">
                                                            <strong class="text-success">Rp</strong>
                                                        </span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control border-left-0 border-right-0 @error('harga_sampah') is-invalid @enderror"
                                                        name="harga_sampah" id="hargaSampah"
                                                        value="{{ old('harga_sampah', $data ? $data->harga_sampah : '') }}"
                                                        placeholder="0" onkeyup="formatCurrency(this); updateProgress();">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-light border-left-0">
                                                            <i class="fas fa-calculator text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                @error('harga_sampah')
                                                    <div class="alert alert-danger mt-2 border-0" style="border-radius: 10px;">
                                                        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="form-text text-muted mt-2">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Masukkan harga dalam rupiah (tanpa titik atau koma)
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Satuan Field -->
                                        <div class="col-lg-4">
                                            <div class="form-group mb-4">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-balance-scale text-info mr-2"></i>
                                                    Satuan
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light border-right-0">
                                                            <i class="fas fa-weight text-info"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        class="form-control custom-select border-left-0 @error('id_master_satuan') is-invalid @enderror"
                                                        name="id_master_satuan" id="satuan"
                                                        onchange="updateProgress()">
                                                        <option value="" selected>-- Pilih Satuan --</option>
                                                        @forelse ($satuan as $val)
                                                            <option value="{{ $val->id }}"
                                                                {{ $data ? ($val->id == $data->id_master_satuan ? 'selected' : '') : '' }}>
                                                                {{ $val->satuan }}
                                                            </option>
                                                        @empty
                                                            <option value="">Tidak ada data</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                @error('id_master_satuan')
                                                    <div class="alert alert-danger mt-2 border-0"
                                                        style="border-radius: 10px;">
                                                        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="form-text text-muted mt-2">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Per satuan harga
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preview Card -->
                                    <div class="preview-card bg-light rounded p-4 mb-4" id="previewCard"
                                        style="display: none; border-left: 4px solid #28a745;">
                                        <h6 class="font-weight-bold text-success mb-3">
                                            <i class="fas fa-eye mr-2"></i>Preview Harga Sampah
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="preview-item">
                                                    <small class="text-muted">Jenis Sampah:</small>
                                                    <div class="font-weight-bold" id="previewJenis">-</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="preview-item">
                                                    <small class="text-muted">Harga:</small>
                                                    <div class="font-weight-bold text-success" id="previewHarga">Rp -
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="preview-item">
                                                    <small class="text-muted">Satuan:</small>
                                                    <div class="font-weight-bold" id="previewSatuan">-</div>
                                                </div>
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
                                                Data akan disimpan dengan aman
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-end">
                                                <a href="/admin/bank/harga"
                                                    class="btn btn-outline-secondary rounded-pill mr-2 px-4">
                                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                                </a>
                                                <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm"
                                                    id="submitBtn" disabled>
                                                    <i class="fas fa-{{ $data ? 'save' : 'plus' }} mr-2"></i>
                                                    {{ $data ? 'PERBARUI' : 'SIMPAN' }}
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
                            <div class="card-header bg-gradient-info text-white" style="border-radius: 15px 15px 0 0;">
                                <h6 class="mb-0">
                                    <i class="fas fa-question-circle mr-2"></i>Bantuan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="help-item mb-3">
                                    <h6 class="font-weight-bold text-success">
                                        <i class="fas fa-recycle mr-2"></i>Jenis Sampah
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Pilih jenis sampah yang akan ditentukan harganya dari daftar yang tersedia.
                                    </p>
                                </div>
                                <div class="help-item mb-3">
                                    <h6 class="font-weight-bold text-warning">
                                        <i class="fas fa-money-bill mr-2"></i>Harga Sampah
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Masukkan harga dalam rupiah. Sistem akan memformat angka secara otomatis.
                                    </p>
                                </div>
                                <div class="help-item">
                                    <h6 class="font-weight-bold text-info">
                                        <i class="fas fa-balance-scale mr-2"></i>Satuan
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Pilih satuan yang sesuai (kg, ton, unit, dll.) untuk penentuan harga.
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

        .form-control:focus,
        .custom-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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

            // Add smooth animations
            $('.card').hide().fadeIn(800);
        });

        // Format currency input
        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            if (!value) {
                input.value = '';
                $('#hargaSampah').val('');
                return;
            }

            const formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = formatted;
            $('#hargaSampah').val(value);
        }

        // Update progress bar
        function updateProgress() {
            let filledFields = 0;
            let totalFields = 3;

            // Check jenis sampah
            if ($('#jenisSampah').val()) filledFields++;

            // Check harga
            if ($('#hargaSampah').val()) filledFields++;

            // Check satuan
            if ($('#satuan').val()) filledFields++;

            let progress = (filledFields / totalFields) * 100;
            $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);

            // Update step indicator
            let step = Math.ceil((progress / 100) * 3);
            $('.badge').html(`<i class="fas fa-info-circle mr-1"></i>Langkah ${step} dari 3`);

            // Enable/disable submit button
            if (progress === 100) {
                $('#submitBtn').prop('disabled', false);
                $('.badge').removeClass('badge-info').addClass('badge-success');
            } else {
                $('#submitBtn').prop('disabled', true);
                $('.badge').removeClass('badge-success').addClass('badge-info');
            }

            updatePreview();
        }

        // Update preview
        function updatePreview() {
            let jenis = $('#jenisSampah option:selected').text();
            let harga = $('#hargaSampah').val();
            let satuan = $('#satuan option:selected').text();

            if (jenis && jenis !== '-- Pilih Jenis Sampah --') {
                $('#previewJenis').text(jenis);
            } else {
                $('#previewJenis').text('-');
            }

            if (harga) {
                $('#previewHarga').text('Rp ' + harga);
            } else {
                $('#previewHarga').text('Rp -');
            }

            if (satuan && satuan !== '-- Pilih Satuan --') {
                $('#previewSatuan').text('per ' + satuan);
            } else {
                $('#previewSatuan').text('-');
            }

            // Show/hide preview card
            if (jenis || harga || satuan) {
                $('#previewCard').slideDown();
            } else {
                $('#previewCard').slideUp();
            }
        }

        // Reset form
        function resetForm() {
            $('#previewCard').slideUp();
            $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
            $('.badge').removeClass('badge-success').addClass('badge-info').html(
                '<i class="fas fa-info-circle mr-1"></i>Langkah 1 dari 3');
            $('#submitBtn').prop('disabled', true);

            setTimeout(() => {
                updateProgress();
            }, 100);
        }

        // Form validation
        $('#hargaForm').on('submit', function(e) {
            let isValid = true;
            let errors = [];

            if (!$('#jenisSampah').val()) {
                errors.push('Jenis sampah harus dipilih');
                isValid = false;
            }

            if (!$('#hargaSampah').val()) {
                errors.push('Harga sampah harus diisi');
                isValid = false;
            }

            if (!$('#satuan').val()) {
                errors.push('Satuan harus dipilih');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Harap lengkapi semua field:\n' + errors.join('\n'));
            } else {
                const val = $('#hargaSampah').val().replace(/\./g, '').replace(/[^0-9]/g, '');
                const cleanValue = $('#hargaSampah').val().replace(/\./g, '').replace(/[^0-9]/g, '');
                $('#hargaSampah').val(parseFloat(cleanValue).toFixed(2));


                $('#submitBtn').html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
                $('#submitBtn').prop('disabled', true);
            }
        });
    </script>
@endsection
