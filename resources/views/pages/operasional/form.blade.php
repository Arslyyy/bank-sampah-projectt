@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gradient"
                        style="background: linear-gradient(45deg, #dc3545, #fd7e14); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                        <i class="fas fa-{{ isset($data) ? 'edit' : 'plus' }} mr-2"></i>
                        {{ isset($data) ? 'Edit' : 'Tambah' }} Operasional
                    </h1>
                    <p class="text-muted mb-0">
                        {{ isset($data) ? 'Perbarui data operasional' : 'Tambah transaksi operasional baru' }}
                    </p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('operasional.index') }}" class="text-danger">
                                <i class="fas fa-briefcase"></i> Operasional
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-secondary">
                            {{ isset($data) ? 'Edit' : 'Create' }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<!-- Main -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Form -->
            <div class="col-lg-8 col-md-7">
                <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header bg-gradient-danger text-white">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-clipboard-list mr-2"></i> Form {{ isset($data) ? 'Edit' : 'Tambah' }} Operasional
                        </h3>
                    </div>

                    <form action="{{ isset($data) ? route('operasional.update', $data->id) : route('operasional.store') }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($data)) @method('PUT') @endif

                        <div class="card-body" style="padding: 2rem;">
                            <!-- Tanggal -->
                            <div class="form-group">
                                <label class="font-weight-bold text-dark mb-2">
                                    <i class="fas fa-calendar-alt text-primary mr-2"></i> Tanggal <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_transaksi" class="form-control"
                                    value="{{ isset($data) ? $data->tanggal_transaksi->format('Y-m-d') : old('tanggal_transaksi') }}" required>
                            </div>

                            <!-- Jenis Operasional -->
                            <div class="form-group">
                                <label class="font-weight-bold text-dark mb-2">
                                    <i class="fas fa-tags text-info mr-2"></i> Jenis Operasional <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="jenis_operasional" class="form-control"
                                    placeholder="Masukkan jenis operasional"
                                    value="{{ isset($data) ? $data->jenis_operasional : old('jenis_operasional') }}" required>
                            </div>

                            <!-- Jumlah -->
                            <div class="form-group">
                                <label class="font-weight-bold text-dark mb-2">
                                    <i class="fas fa-coins text-warning mr-2"></i> Jumlah <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="jumlah" class="form-control rupiah"
                                    placeholder="0" value="{{ isset($data) ? number_format($data->jumlah, 0, ',', '.') : old('jumlah') }}" required>
                            </div>

                            <!-- Keterangan -->
                            <div class="form-group">
                                <label class="font-weight-bold text-dark mb-2">
                                    <i class="fas fa-align-left text-secondary mr-2"></i> Keterangan
                                </label>
                                <textarea name="uraian" class="form-control" rows="3" placeholder="Keterangan tambahan...">{{ isset($data) ? $data->keterangan : old('keterangan') }}</textarea>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer bg-light d-flex justify-content-end" style="padding: 1.5rem 2rem;">
                            <a href="{{ route('operasional.index') }}" class="btn btn-outline-secondary rounded-pill mr-2 px-4">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i>
                                {{ isset($data) ? 'PERBARUI' : 'SIMPAN' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bantuan -->
            <div class="col-lg-4 col-md-5">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-warning text-white">
                        <h6 class="mb-0"><i class="fas fa-question-circle mr-2"></i> Bantuan</h6>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0 text-muted">
                            <li>Tanggal wajib diisi.</li>
                            <li>Jenis operasional diisi sesuai kebutuhan</li>
                            <li>Nominal otomatis diformat ke Rupiah.</li>
                            <li>Uraian opsional sebagai catatan tambahan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>

<!-- JS: Format Rupiah -->
<script>
    document.addEventListener("input", e => {
        if (e.target.classList.contains("rupiah")) {
            let value = e.target.value.replace(/\D/g, "");
            e.target.value = new Intl.NumberFormat("id-ID").format(value);
        }
    });
</script>
@endsection
