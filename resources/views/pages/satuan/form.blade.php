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
                            <i class="fas fa-{{ $data ? 'edit' : 'plus-circle' }} text-primary mr-2"></i>
                            @if ($data)
                                Edit Satuan
                            @else
                                Tambah Satuan Baru
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
                                <a href="/bank/satuan" class="text-decoration-none">
                                    <i class="fas fa-weight-hanging"></i> Satuan
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                @if ($data)
                                    Edit Satuan
                                @else
                                    Tambah Satuan
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
                    <div class="col-lg-8 col-md-10">

                        <!-- Info Alert -->
                        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Informasi:</strong>
                            @if ($data)
                                Anda sedang mengedit data satuan "<strong>{{ $data->satuan }}</strong>". Pastikan data yang
                                diubah sudah benar.
                            @else
                                Silakan isi form di bawah untuk menambahkan satuan baru ke dalam sistem.
                            @endif
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-gradient-{{ $data ? 'warning' : 'primary' }} text-white">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <i class="fas fa-{{ $data ? 'edit' : 'plus-circle' }} fa-2x"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title mb-0 font-weight-bold">
                                            @if ($data)
                                                Edit Data Satuan
                                            @else
                                                Tambah Data Satuan Baru
                                            @endif
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <form class="form-horizontal"
                                action="{{ request()->is('admin/bank/satuan/create') ? url('admin/bank/satuan/store') : url('admin/bank/satuan/update', $data->id) }}"
                                method="POST" enctype="multipart/form-data" id="satuanForm">
                                @csrf
                                @if ($data)
                                    @method('PUT')
                                @else
                                    @method('POST')
                                @endif

                                <div class="card-body p-4">
                                    <!-- Form Preview Card -->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <!-- Main Form -->
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark">
                                                    <i class="fas fa-balance-scale text-primary mr-2"></i>
                                                    Nama Satuan <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light">
                                                            <i class="fas fa-weight-hanging text-muted"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-lg @error('satuan') is-invalid @enderror"
                                                        name="satuan"
                                                        value="{{ old('satuan', $data ? $data->satuan : '') }}"
                                                        placeholder="Masukkan nama satuan (contoh: Kg, Gram, Liter)"
                                                        id="satuanInput" autocomplete="off">
                                                    @error('satuan')
                                                        <div class="invalid-feedback d-block">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-lightbulb mr-1"></i>
                                                    Contoh satuan yang umum digunakan: Kg, Gram, Ton, Liter, Piece, dll.
                                                </small>
                                            </div>

                                            <!-- Quick Select Buttons -->
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark mb-2">
                                                    <i class="fas fa-mouse-pointer text-success mr-2"></i>
                                                    Pilih Cepat Satuan Umum
                                                </label>
                                                <div class="d-flex flex-wrap">
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm mr-2 mb-2 quick-select"
                                                        data-value="Kg">
                                                        <i class="fas fa-weight mr-1"></i>Kilogram
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm mr-2 mb-2 quick-select"
                                                        data-value="Gram">
                                                        <i class="fas fa-weight mr-1"></i>Gram
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm mr-2 mb-2 quick-select"
                                                        data-value="Liter">
                                                        <i class="fas fa-tint mr-1"></i>Liter
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm mr-2 mb-2 quick-select"
                                                        data-value="Piece">
                                                        <i class="fas fa-cube mr-1"></i>Piece
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm mr-2 mb-2 quick-select"
                                                        data-value="Ton">
                                                        <i class="fas fa-weight-hanging mr-1"></i>Ton
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Card -->
                                        <div class="col-md-4">
                                            <div class="card border-left-primary shadow-sm h-100">
                                                <div class="card-header bg-light">
                                                    <h6 class="m-0 font-weight-bold text-primary">
                                                        <i class="fas fa-eye mr-2"></i>Preview
                                                    </h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    <div class="preview-icon mb-3">
                                                        <div class="bg-primary rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px;">
                                                            <i class="fas fa-balance-scale text-white fa-2x"></i>
                                                        </div>
                                                    </div>
                                                    <h5 class="preview-text font-weight-bold text-dark" id="previewText">
                                                        {{ old('satuan', $data ? $data->satuan : 'Nama Satuan') }}
                                                    </h5>
                                                    <p class="text-muted small mb-0">Satuan Bank Sampah</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-light p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="d-flex">
                                                <button type="submit"
                                                    class="btn btn-{{ $data ? 'warning' : 'primary' }} btn-lg mr-3 shadow-sm"
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
                                                <a href="/admin/bank/satuan" class="btn btn-outline-dark btn-lg">
                                                    <i class="fas fa-arrow-left mr-2"></i>
                                                    KEMBALI KE LIST
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Help Card -->
                        <div class="card border-left-info shadow-sm mt-4">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-info mb-3">
                                    <i class="fas fa-question-circle mr-2"></i>
                                    Bantuan & Tips
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold">✅ Contoh Satuan yang Baik:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success mr-2"></i>Kg, Gram, Ton</li>
                                            <li><i class="fas fa-check text-success mr-2"></i>Liter, ml</li>
                                            <li><i class="fas fa-check text-success mr-2"></i>Piece, Unit</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold">❌ Hindari:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-times text-danger mr-2"></i>Nama terlalu panjang</li>
                                            <li><i class="fas fa-times text-danger mr-2"></i>Karakter khusus berlebihan
                                            </li>
                                            <li><i class="fas fa-times text-danger mr-2"></i>Duplikasi satuan</li>
                                        </ul>
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
                    <p class="text-muted">Data satuan telah berhasil {{ $data ? 'diperbarui' : 'ditambahkan' }} ke dalam
                        sistem.</p>
                </div>
                <div class="modal-footer">
                    <a href="/bank/satuan" class="btn btn-success">
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
            $('#satuanInput').on('input', function() {
                var value = $(this).val();
                $('#previewText').text(value || 'Nama Satuan');
            });

            // Quick select functionality
            $('.quick-select').on('click', function() {
                var value = $(this).data('value');
                $('#satuanInput').val(value).trigger('input');

                // Add visual feedback
                $('.quick-select').removeClass('btn-primary').addClass('btn-outline-primary');
                $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            });

            // Form validation
            $('#satuanForm').on('submit', function(e) {
                var satuan = $('#satuanInput').val().trim();

                if (satuan === '') {
                    e.preventDefault();
                    toastr.error('Nama satuan tidak boleh kosong!');
                    $('#satuanInput').focus();
                    return false;
                }

                if (satuan.length < 2) {
                    e.preventDefault();
                    toastr.error('Nama satuan minimal 2 karakter!');
                    $('#satuanInput').focus();
                    return false;
                }

                // Show loading state
                $('#submitBtn').html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
                $('#submitBtn').prop('disabled', true);
            });

            // Reset button functionality
            $('#resetBtn').on('click', function() {
                $('#previewText').text('Nama Satuan');
                $('.quick-select').removeClass('btn-primary').addClass('btn-outline-primary');
                toastr.info('Form telah direset');
            });

            // Auto-focus on input
            $('#satuanInput').focus();

            // Input formatting
            $('#satuanInput').on('input', function() {
                var value = $(this).val();
                // Capitalize first letter
                if (value.length > 0) {
                    $(this).val(value.charAt(0).toUpperCase() + value.slice(1));
                }
            });
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
        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #ffc107, #e0a800);
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
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
            border-color: #007bff;
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

        .border-left-primary {
            border-left: 4px solid #007bff !important;
        }

        .border-left-info {
            border-left: 4px solid #17a2b8 !important;
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

        @media (max-width: 768px) {
            .d-flex.justify-content-end {
                justify-content: center !important;
                margin-top: 1rem;
            }

            .btn-lg {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endpush
