<!-- Content Wrapper. Contains page content -->
@extends('adminlte.layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <i class="fas fa-{{ $data ? 'edit' : 'plus-circle' }} text-success mr-2"></i>
                            @if ($data)
                                Edit Jenis Sampah
                            @else
                                Tambah Jenis Sampah Baru
                            @endif
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/admin/bank/jenis" class="text-decoration-none">
                                    <i class="fas fa-recycle"></i> Jenis Sampah
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                @if ($data)
                                    Edit Jenis Sampah
                                @else
                                    Tambah Jenis Sampah
                                @endif
                            </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12">

                        <!-- Info Alert -->
                        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Informasi:</strong>
                            @if ($data)
                                Anda sedang mengedit data jenis sampah "<strong>{{ $data->type_sampah }}</strong>". Pastikan
                                data yang diubah sudah benar.
                            @else
                                Silakan isi form di bawah untuk menambahkan jenis sampah baru ke dalam sistem bank sampah.
                            @endif
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="row">
                            <!-- Form Section -->
                            <div class="col-lg-8">
                                <div class="card shadow-lg border-0">
                                    <div class="card-header bg-gradient-{{ $data ? 'warning' : 'success' }} text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="fas fa-{{ $data ? 'edit' : 'plus-circle' }} fa-2x"></i>
                                            </div>
                                            <div>
                                                <h3 class="card-title mb-0 font-weight-bold">
                                                    @if ($data)
                                                        Edit Data Jenis Sampah
                                                    @else
                                                        Tambah Jenis Sampah Baru
                                                    @endif
                                                </h3>
                                                <p class="mb-0 opacity-75">
                                                    @if ($data)
                                                        Perbarui informasi jenis sampah yang sudah ada
                                                    @else
                                                        Masukkan informasi jenis sampah baru untuk bank sampah
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <form class="form-horizontal"
                                        action="{{ request()->is('admin/bank/jenis/create') ? url('admin/bank/jenis/store') : url('admin/bank/jenis/update', $data->id) }}"
                                        method="POST" enctype="multipart/form-data" id="jenisSampahForm">
                                        @csrf
                                        @if ($data)
                                            @method('PUT')
                                        @else
                                            @method('POST')
                                        @endif

                                        <div class="card-body p-4">
                                            <!-- Main Form Input -->
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark">
                                                    <i class="fas fa-recycle text-green mr-2"></i>
                                                    Jenis / Type Sampah <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light">
                                                            <i class="fas fa-trash-alt text-muted"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-lg @error('type_sampah') is-invalid @enderror"
                                                        name="type_sampah"
                                                        value="{{ old('type_sampah', $data ? $data->type_sampah : '') }}"
                                                        placeholder="Masukkan jenis sampah (contoh: Plastik, Kertas, Logam)"
                                                        id="typeSampahInput" autocomplete="off">
                                                    @error('type_sampah')
                                                        <div class="invalid-feedback d-block">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-lightbulb mr-1"></i>
                                                    Contoh jenis sampah: Plastik, Kertas, Logam, Kaca, Organik, Elektronik,
                                                    dll.
                                                </small>
                                            </div>

                                            <!-- Quick Select Categories -->
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-mouse-pointer text-primary mr-2"></i>
                                                    Pilih Kategori Umum
                                                </label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="category-group mb-3">
                                                            <h6 class="font-weight-bold text-muted">Sampah Anorganik</h6>
                                                            <div class="d-flex flex-wrap">
                                                                <button type="button"
                                                                    class="btn btn-outline-primary btn-sm mr-2 mb-2 quick-select"
                                                                    data-value="Plastik" data-icon="fas fa-shopping-bag"
                                                                    data-color="primary">
                                                                    <i class="fas fa-shopping-bag mr-1"></i>Plastik
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-info btn-sm mr-2 mb-2 quick-select"
                                                                    data-value="Kertas" data-icon="fas fa-newspaper"
                                                                    data-color="info">
                                                                    <i class="fas fa-newspaper mr-1"></i>Kertas
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm mr-2 mb-2 quick-select"
                                                                    data-value="Logam" data-icon="fas fa-cog"
                                                                    data-color="secondary">
                                                                    <i class="fas fa-cog mr-1"></i>Logam
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-dark btn-sm mr-2 mb-2 quick-select"
                                                                    data-value="Kaca" data-icon="fas fa-wine-glass"
                                                                    data-color="dark">
                                                                    <i class="fas fa-wine-glass mr-1"></i>Kaca
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="category-group mb-3">
                                                            <h6 class="font-weight-bold text-muted">Sampah Khusus</h6>
                                                            <div class="d-flex flex-wrap">
                                                                <button type="button"
                                                                    class="btn btn-outline-success btn-sm mr-2 mb-2 quick-select"
                                                                    data-value="Organik" data-icon="fas fa-leaf"
                                                                    data-color="success">
                                                                    <i class="fas fa-leaf mr-1"></i>Organik
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-warning btn-sm mr-2 mb-2 quick-select"
                                                                    data-value="Elektronik" data-icon="fas fa-microchip"
                                                                    data-color="warning">
                                                                    <i class="fas fa-microchip mr-1"></i>Elektronik
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm mr-2 mb-2 quick-select"
                                                                    data-value="Tekstil" data-icon="fas fa-tshirt"
                                                                    data-color="danger">
                                                                    <i class="fas fa-tshirt mr-1"></i>Tekstil
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Custom Input for Subcategories -->
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark">
                                                    <i class="fas fa-pencil-alt text-warning mr-2"></i>
                                                    Atau Buat Kategori Khusus
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="customCategory"
                                                        placeholder="Tulis jenis sampah khusus...">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            id="addCustom">
                                                            <i class="fas fa-plus"></i> Tambah
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer bg-light p-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="d-flex">
                                                        <button type="submit"
                                                            class="btn btn-{{ $data ? 'warning' : 'success' }} btn-lg mr-3 shadow-sm"
                                                            id="submitBtn">
                                                            <i class="fas fa-{{ $data ? 'save' : 'plus' }} mr-2"></i>
                                                            @if ($data)
                                                                PERBARUI DATA
                                                            @else
                                                                SIMPAN DATA
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="/admin/bank/jenis" class="btn btn-outline-dark btn-lg">
                                                            <i class="fas fa-arrow-left mr-2"></i>
                                                            KEMBALI KE LIST
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Preview & Info Section -->
                            <div class="col-lg-4">
                                <!-- Preview Card -->
                                <div class="card border-left-success shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 font-weight-bold text-success">
                                            <i class="fas fa-eye mr-2"></i>Preview
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="preview-icon mb-3">
                                            <div class="bg-success rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                                style="width: 70px; height: 70px;" id="previewIcon">
                                                <i class="fas fa-recycle text-white fa-2x"></i>
                                            </div>
                                        </div>
                                        <h5 class="preview-text font-weight-bold text-dark" id="previewText">
                                            {{ old('type_sampah', $data ? $data->type_sampah : 'Jenis Sampah') }}
                                        </h5>
                                        <p class="text-muted small mb-0">Kategori Bank Sampah</p>
                                        <div class="mt-3">
                                            <span class="badge badge-success badge-pill px-3 py-2">
                                                <i class="fas fa-check mr-1"></i>
                                                Siap Disimpan
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Statistics Card -->
                                <div class="card border-left-info shadow-sm mb-4">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold text-info mb-3">
                                            <i class="fas fa-chart-bar mr-2"></i>
                                            Statistik Jenis Sampah
                                        </h6>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border-right">
                                                    <h4 class="font-weight-bold text-primary">15</h4>
                                                    <small class="text-muted">Total Jenis</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="font-weight-bold text-success">8</h4>
                                                <small class="text-muted">Kategori Aktif</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Help Card -->
                                <div class="card border-left-warning shadow-sm">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold text-warning mb-3">
                                            <i class="fas fa-question-circle mr-2"></i>
                                            Tips & Bantuan
                                        </h6>
                                        <div class="mb-3">
                                            <h6 class="font-weight-bold">✅ Contoh Yang Baik:</h6>
                                            <ul class="list-unstyled small">
                                                <li><i class="fas fa-check text-success mr-2"></i>Plastik PET</li>
                                                <li><i class="fas fa-check text-success mr-2"></i>Kertas HVS</li>
                                                <li><i class="fas fa-check text-success mr-2"></i>Logam Aluminium</li>
                                            </ul>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold">❌ Hindari:</h6>
                                            <ul class="list-unstyled small">
                                                <li><i class="fas fa-times text-danger mr-2"></i>Nama terlalu umum</li>
                                                <li><i class="fas fa-times text-danger mr-2"></i>Duplikasi kategori</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="fas fa-check-circle mr-2"></i>
                        Berhasil!
                    </h5>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Data Berhasil Disimpan!</h4>
                    <p class="text-muted">Jenis sampah telah berhasil {{ $data ? 'diperbarui' : 'ditambahkan' }} ke dalam
                        sistem.</p>
                </div>
                <div class="modal-footer">
                    <a href="/bank/jenis" class="btn btn-success">
                        <i class="fas fa-list mr-1"></i>
                        Lihat Semua Data
                    </a>
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">
                        <i class="fas fa-plus mr-1"></i>
                        Tambah Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Real-time preview update
            $('#typeSampahInput').on('input', function() {
                var value = $(this).val();
                $('#previewText').text(value || 'Jenis Sampah');

                // Update icon based on input
                updatePreviewIcon(value);
            });

            // Update preview icon based on waste type
            function updatePreviewIcon(type) {
                var iconClass = 'fas fa-recycle';
                var colorClass = 'bg-success';

                if (type.toLowerCase().includes('plastik')) {
                    iconClass = 'fas fa-shopping-bag';
                    colorClass = 'bg-primary';
                } else if (type.toLowerCase().includes('kertas')) {
                    iconClass = 'fas fa-newspaper';
                    colorClass = 'bg-info';
                } else if (type.toLowerCase().includes('logam')) {
                    iconClass = 'fas fa-cog';
                    colorClass = 'bg-secondary';
                } else if (type.toLowerCase().includes('kaca')) {
                    iconClass = 'fas fa-wine-glass';
                    colorClass = 'bg-dark';
                } else if (type.toLowerCase().includes('organik')) {
                    iconClass = 'fas fa-leaf';
                    colorClass = 'bg-success';
                } else if (type.toLowerCase().includes('elektronik')) {
                    iconClass = 'fas fa-microchip';
                    colorClass = 'bg-warning';
                } else if (type.toLowerCase().includes('tekstil')) {
                    iconClass = 'fas fa-tshirt';
                    colorClass = 'bg-danger';
                }

                $('#previewIcon').removeClass().addClass(
                    'rounded-circle mx-auto d-flex align-items-center justify-content-center ' + colorClass);
                $('#previewIcon i').removeClass().addClass(iconClass + ' text-white fa-2x');
            }

            // Quick select functionality
            $('.quick-select').on('click', function() {
                var value = $(this).data('value');
                var icon = $(this).data('icon');
                var color = $(this).data('color');

                $('#typeSampahInput').val(value).trigger('input');

                // Add visual feedback
                $('.quick-select').each(function() {
                    var originalColor = $(this).data('color');
                    $(this).removeClass('btn-' + originalColor).addClass('btn-outline-' +
                        originalColor);
                });
                $(this).removeClass('btn-outline-' + color).addClass('btn-' + color);
            });

            // Custom category functionality
            $('#addCustom').on('click', function() {
                var customValue = $('#customCategory').val().trim();
                if (customValue) {
                    $('#typeSampahInput').val(customValue).trigger('input');
                    $('#customCategory').val('');
                    toastr.success('Kategori khusus ditambahkan!');
                }
            });

            // Enter key for custom category
            $('#customCategory').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#addCustom').click();
                }
            });

            // Form validation
            $('#jenisSampahForm').on('submit', function(e) {
                var typeSampah = $('#typeSampahInput').val().trim();

                if (typeSampah === '') {
                    e.preventDefault();
                    toastr.error('Jenis sampah tidak boleh kosong!');
                    $('#typeSampahInput').focus();
                    return false;
                }

                if (typeSampah.length < 2) {
                    e.preventDefault();
                    toastr.error('Jenis sampah minimal 2 karakter!');
                    $('#typeSampahInput').focus();
                    return false;
                }

                // Show loading state
                $('#submitBtn').html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
                $('#submitBtn').prop('disabled', true);
            });

            // Reset button functionality
            $('#resetBtn').on('click', function() {
                $('#previewText').text('Jenis Sampah');
                $('#previewIcon').removeClass().addClass(
                    'bg-success rounded-circle mx-auto d-flex align-items-center justify-content-center'
                );
                $('#previewIcon i').removeClass().addClass('fas fa-recycle text-white fa-2x');
                $('.quick-select').each(function() {
                    var color = $(this).data('color');
                    $(this).removeClass('btn-' + color).addClass('btn-outline-' + color);
                });
                $('#customCategory').val('');
                toastr.info('Form telah direset');
            });

            // Auto-focus on input
            $('#typeSampahInput').focus();

            // Input formatting
            $('#typeSampahInput').on('input', function() {
                var value = $(this).val();
                // Capitalize first letter of each word
                if (value.length > 0) {
                    var formatted = value.replace(/\w\S*/g, function(txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
                    $(this).val(formatted);
                }
            });

            // Initialize preview if editing
            @if ($data)
                updatePreviewIcon('{{ $data->type_sampah }}');
            @endif
        });

        // Show success message
        @if (session('success'))
            $(document).ready(function() {
                $('#successModal').modal('show');
                toastr.success('{{ session('success') }}');
            });
        @endif

        // Show error message
        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif

        // Validation errors
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    </script>

    <style>
        .bg-gradient-success {
            background: linear-gradient(45deg, #28a745, #20c997);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .form-control-lg {
            border-radius: 10px;
            border: 2px solid #e3e6f0;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
            border-color: #28a745;
        }

        .btn {
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .quick-select {
            transition: all 0.3s ease;
        }

        .quick-select:hover {
            transform: scale(1.05);
        }

        .border-left-success {
            border-left: 4px solid #28a745 !important;
        }

        .border-left-info {
            border-left: 4px solid #17a2b8 !important;
        }

        .border-left-warning {
            border-left: 4px solid #ffc107 !important;
        }

        .preview-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e3e6f0;
            border-right: none;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .category-group {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #dee2e6;
        }

        .text-green {
            color: #28a745 !important;
        }

        .border-right {
            border-right: 1px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .d-flex.justify-content-end {
                justify-content: center !important;
                margin-top: 1rem;
            }

            .btn-lg {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .border-right {
                border-right: none;
                border-bottom: 1px solid #dee2e6;
                padding-bottom: 1rem;
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush
