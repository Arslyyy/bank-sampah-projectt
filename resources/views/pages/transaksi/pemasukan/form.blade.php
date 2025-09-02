{{-- resources/views/transaksi/pemasukan/form.blade.php --}}
@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gradient"
                        style="background: linear-gradient(45deg, #28a745, #20c997); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                        <i class="fas fa-{{ isset($data) ? 'edit' : 'plus-circle' }} mr-2"></i>
                        {{ isset($data) ? 'Edit' : 'Tambah' }} Transaksi Pemasukan
                    </h1>
                    <p class="text-muted mb-0">
                        {{ isset($data) ? 'Perbarui data pemasukan' : 'Tambahkan pemasukan baru ke sistem' }}
                    </p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pemasukkan.index') }}" class="text-success">
                                <i class="fas fa-coins"></i> Pemasukan
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- Form Card -->
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-header bg-gradient-success text-white" style="padding: 1.5rem;">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-25 rounded-circle p-3 mr-3">
                                    <i class="fas fa-{{ isset($data) ? 'edit' : 'plus' }} fa-lg"></i>
                                </div>
                                <div>
                                    <h3 class="card-title mb-1">Form {{ isset($data) ? 'Edit' : 'Tambah' }} Pemasukan</h3>
                                </div>
                            </div>
                        </div>

                        <form id="pemasukanForm"
                              action="{{ isset($data) ? route('pemasukkan.update', $data->id) : route('pemasukkan.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($data)) @method('PUT') @endif

                            <div class="card-body" style="padding: 2rem;">
                                <div id="form-container">
                                    {{-- MODE EDIT --}}
                                    @if(isset($data))
                                        <div class="pemasukan-form mb-4">
                                            <!-- ID Transaksi -->
                                            <div class="form-group mb-4">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-barcode text-secondary mr-2"></i>
                                                    ID Transaksi
                                                </label>
                                                <input type="text" class="form-control" name="id_transaksi"
                                                       value="{{ old('id_transaksi', $data->id_transaksi) }}" readonly>
                                            </div>

                                            <!-- Tanggal -->
                                            <div class="form-group mb-4">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                                    Tanggal Transaksi <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" class="form-control" name="tanggal_transaksi"
                                                       value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($data->tanggal_transaksi)->format('Y-m-d')) }}"
                                                       required>
                                            </div>

                                            <!-- Jumlah -->
                                            <div class="form-group mb-4">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-coins text-warning mr-2"></i>
                                                    Jumlah <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control jumlah"
                                                       name="jumlah" value="{{ old('jumlah', $data->jumlah) }}" required>
                                            </div>

                                            <!-- Uraian -->
                                            <div class="form-group mb-4">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-sticky-note text-info mr-2"></i>
                                                    Uraian / Keterangan
                                                </label>
                                                <textarea name="uraian" class="form-control">{{ old('uraian', $data->uraian) }}</textarea>
                                            </div>

                                            <!-- Upload Nota -->
                                            <div class="form-group mb-4">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-upload text-success mr-2"></i>
                                                    Upload Nota
                                                </label>
                                                @if($data->image)
                                                    <p><img src="{{ asset('storage/'.$data->image) }}" width="150" class="mb-2 rounded"></p>
                                                @endif
                                                <input type="file" name="image" class="form-control-file">
                                            </div>
                                        </div>
                                    @else
                                    {{-- MODE CREATE (Multiple) --}}
                                        <div class="pemasukan-form border rounded p-3 mb-4">
                                            <h6 class="text-success mb-3"><i class="fas fa-plus-circle mr-1"></i> Data Pemasukan</h6>

                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-barcode text-secondary mr-2"></i>
                                                    ID Transaksi
                                                </label>
                                                <input type="text" name="id_transaksi[]" class="form-control id-transaksi" readonly>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                                    Tanggal Transaksi <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" name="tanggal_transaksi[]" class="form-control" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-coins text-warning mr-2"></i>
                                                    Jumlah <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="jumlah[]" class="form-control jumlah" placeholder="Rp 0" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-sticky-note text-info mr-2"></i>
                                                    Uraian / Keterangan
                                                </label>
                                                <textarea name="uraian[]" class="form-control" placeholder="Masukkan keterangan"></textarea>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-dark mb-3">
                                                    <i class="fas fa-upload text-success mr-2"></i>
                                                    Upload Nota
                                                </label>
                                                <input type="file" name="image[]" class="form-control-file">
                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-danger remove-form" style="display:none">
                                                <i class="fas fa-trash mr-1"></i> Hapus Form
                                            </button>
                                        </div>
                                    @endif
                                </div>

                            <!-- Footer -->
                            <div class="card-footer bg-light" style="padding: 1.5rem 2rem;">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('pemasukkan.index') }}" class="btn btn-outline-secondary rounded-pill mr-2 px-4">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                    @if(!isset($data))
                                    <button type="button" class="btn btn-outline-info rounded-pill mr-2 px-4" onclick="tambahForm()">
                                        <i class="fas fa-plus mr-2"></i>Tambah Form
                                    </button>
                                    @endif
                                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm" id="submitBtn">
                                        <i class="fas fa-{{ isset($data) ? 'save' : 'plus' }} mr-2"></i>
                                        {{ isset($data) ? 'PERBARUI' : 'SIMPAN' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                        <div class="card-header bg-gradient-info text-white">
                            <h6 class="mb-0"><i class="fas fa-question-circle mr-2"></i>Bantuan</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-2">Isi semua field untuk menyimpan pemasukan.</p>
                            <ul class="small mb-0">
                                <li>ID transaksi dibuat otomatis.</li>
                                <li>Tanggal wajib diisi.</li>
                                <li>Jumlah otomatis diformat ke Rupiah.</li>
                                <li>Uraian opsional untuk keterangan tambahan.</li>
                                <li>Nota bisa diupload sebagai bukti transaksi.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

{{-- JS: pakai ulang format rupiah + dynamic form --}}
<script>
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        if (!value) { input.value = ''; return; }
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    document.addEventListener("input", e => {
        if(e.target.classList.contains("jumlah")) formatCurrency(e.target);
    });

    function generateIdTransaksi() {
        const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        let result = "";
        for (let i = 0; i < 6; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    function tambahForm() {
        let container = document.getElementById('form-container');
        let firstForm = document.querySelector('.pemasukan-form');
        let newForm = firstForm.cloneNode(true);

        // reset input
        newForm.querySelectorAll('input,textarea').forEach(el => el.value = "");
        // generate id baru
        let idField = newForm.querySelector('input[name="id_transaksi[]"]');
        if(idField) idField.value = generateIdTransaksi();

        // tampilkan tombol hapus
        let removeBtn = newForm.querySelector('.remove-form');
        if(removeBtn) removeBtn.style.display = "inline-block";

        container.appendChild(newForm);
    }

    document.addEventListener("DOMContentLoaded", () => {
        let firstId = document.querySelector('input[name="id_transaksi[]"]');
        if(firstId) firstId.value = generateIdTransaksi();
    });

    document.addEventListener("click", e => {
        if(e.target.closest(".remove-form")) {
            e.target.closest(".pemasukan-form").remove();
        }
    });
</script>
@endsection
