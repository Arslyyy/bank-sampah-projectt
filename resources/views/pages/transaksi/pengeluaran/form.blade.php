{{-- resources/views/transaksi/pengeluaran/form.blade.php --}}
@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gradient"
                        style="background: linear-gradient(45deg, #dc3545, #fd7e14); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                        <i class="fas fa-{{ isset($data) ? 'edit' : 'minus-circle' }} mr-2"></i>
                        {{ isset($data) ? 'Edit' : 'Tambah' }} Transaksi Pengeluaran
                    </h1>
                    <p class="text-muted mb-0">
                        {{ isset($data) ? 'Perbarui informasi transaksi pengeluaran' : 'Tambahkan pengeluaran baru ke sistem' }}
                    </p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pengeluaran.index') }}" class="text-danger">
                                <i class="fas fa-money-bill-wave"></i> Pengeluaran
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
                        <div class="card-header bg-gradient-danger text-white" style="padding: 1.5rem;">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-25 rounded-circle p-3 mr-3">
                                    <i class="fas fa-{{ isset($data) ? 'edit' : 'minus' }} fa-lg"></i>
                                </div>
                                <div>
                                    <h3 class="card-title mb-1">Form {{ isset($data) ? 'Edit' : 'Tambah' }} Pengeluaran</h3>
                                </div>
                            </div>
                        </div>

                        <form action="{{ isset($data) ? route('pengeluaran.update', $data->id) : route('pengeluaran.store') }}" method="POST" id="pengeluaranForm" enctype="multipart/form-data">
                            @csrf
                            @if(isset($data)) @method('PUT') @endif

                            <div class="card-body" style="padding: 2rem;" id="form-container">

                               
                                {{-- MODE EDIT MULTIPLE-LIKE --}}
                                @if(isset($data))
                                <div class="pengeluaran-form border rounded p-3 mb-4">
                                    <h6 class="text-danger mb-3"><i class="fas fa-edit mr-1"></i> Edit Data Pengeluaran</h6>

                                    <!-- ID Transaksi -->
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark mb-2">
                                            <i class="fas fa-barcode text-secondary mr-2"></i> ID Transaksi
                                        </label>
                                        <input type="text" name="{{ isset($data) ? 'id_transaksi' : 'id_transaksi[]' }}" class="form-control" value="{{ $data->id_transaksi }}" readonly>
                                    </div>

                                    <!-- Tanggal -->
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark mb-2">
                                            <i class="fas fa-calendar-alt text-primary mr-2"></i> Tanggal Transaksi <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="{{ isset($data) ? 'tanggal_transaksi' : 'tanggal_transaksi[]' }}" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('Y-m-d') }}" required>
                                    </div>

                                    <!-- Nasabah -->
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark mb-2">
                                            <i class="fas fa-user text-success mr-2"></i> Nasabah
                                        </label>
                                        <select name="{{ isset($data) ? 'master_nasabah_id' : 'master_nasabah_id[]' }}" class="form-control">
                                            <option value="">-- Pilih Nasabah --</option>
                                            @foreach($nasabah as $n)
                                                <option value="{{ $n->id }}" {{ $data->master_nasabah_id == $n->id ? 'selected' : '' }}>{{ $n->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Jenis Sampah -->
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark mb-2">
                                            <i class="fas fa-recycle text-info mr-2"></i> Jenis Sampah
                                        </label>
                                        <select name="{{ isset($data) ? 'id_master_jenis_sampah' : 'id_master_jenis_sampah[]' }}" class="form-control jenis-sampah">
                                            <option value="">-- Pilih Jenis Sampah --</option>
                                            @foreach($jenisSampah as $js)
                                                <option value="{{ $js->id }}" data-harga="{{ $js->harga }}"
                                                    {{ $data->master_jenis_sampah_id == $js->id ? 'selected' : '' }}>
                                                    {{ $js->type_sampah }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Harga per Satuan --}}
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark mb-2">
                                            <i class="fas fa-tag text-success mr-2"></i> Harga per Satuan
                                        </label>
                                        <input type="text" class="form-control harga-sampah" 
                                            value="Rp {{ number_format($data->jenisSampah->harga_sampah ?? 0, 0, ',', '.') }}" readonly>
                                        <input type="hidden" class="harga-sampah-raw" value="{{ $data->jenisSampah->harga ?? 0 }}">
                                    </div>

                                    {{-- Berat Sampah --}}
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark mb-2">
                                            <i class="fas fa-balance-scale text-warning mr-2"></i> Berat Sampah <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="{{ isset($data) ? 'total' : 'total[]' }}" class="form-control jumlah"
                                            value="{{ $data->jumlah_berat }}" onkeyup="hitungTotal(this)">
                                    </div>

                                    {{-- Total --}}
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-dark mb-2">
                                            <i class="fas fa-calculator text-primary mr-2"></i> Total
                                        </label>
                                        <input type="text" class="form-control total"
                                            value="Rp {{ number_format($data->jumlah ?? 0, 0, ',', '.') }}" readonly>
                                        <input type="hidden" name="{{ isset($data) ? 'jumlah' : 'jumlah[]' }}" class="total-raw" value="{{ $data->jumlah ?? 0 }}">
                                    </div>

                                    <button type="button" class="btn btn-sm btn-outline-danger remove-form" style="display:none;">
                                        <i class="fas fa-trash mr-1"></i> Hapus Form
                                    </button>
                                </div>

                                @else
                                    {{-- MODE CREATE MULTIPLE --}}
                                    <div class="pengeluaran-form border rounded p-3 mb-4">
                                        <h6 class="text-danger mb-3">
                                            <i class="fas fa-minus-circle mr-1"></i> Data Pengeluaran
                                        </h6>

                                        <!-- ID Transaksi -->
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">
                                                <i class="fas fa-barcode text-secondary mr-2"></i> ID Transaksi
                                            </label>
                                            <input type="text" name="id_transaksi[]" class="form-control" readonly>
                                        </div>

                                        <!-- Tanggal -->
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">
                                                <i class="fas fa-calendar-alt text-primary mr-2"></i> 
                                                Tanggal Transaksi <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="tanggal_transaksi[]" class="form-control" required>
                                        </div>

                                        <!-- Nasabah -->
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">
                                                <i class="fas fa-user text-success mr-2"></i> Nasabah
                                            </label>
                                            <select name="master_nasabah_id[]" class="form-control">
                                                <option value="">-- Pilih Nasabah --</option>
                                                @foreach($nasabah as $n)
                                                    <option value="{{ $n->id }}">{{ $n->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Jenis Sampah -->
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">
                                                <i class="fas fa-recycle text-info mr-2"></i> Jenis Sampah
                                            </label>
                                            <select name="id_master_jenis_sampah[]" class="form-control jenis-sampah">
                                                <option value="">-- Pilih Jenis Sampah --</option>
                                                @foreach($jenisSampah as $js)
                                                    <option value="{{ $js->id }}" data-harga="{{ $js->harga }}">
                                                        {{ $js->type_sampah }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Harga (otomatis) -->
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">
                                                <i class="fas fa-tag text-success mr-2"></i> Harga per Satuan
                                            </label>
                                            <input type="text" class="form-control harga-sampah" placeholder="Rp 0" readonly>
                                            <input type="hidden" class="harga-sampah-raw" value="0">
                                        </div>

                                        <!-- Berat Sampah -->
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">
                                                <i class="fas fa-balance-scale text-warning mr-2"></i> 
                                                Berat Sampah <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="total[]" 
                                                class="form-control jumlah" 
                                                placeholder="0" 
                                                onkeyup="hitungTotal(this)">
                                        </div>

                                        <!-- Total (otomatis) -->
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">
                                                <i class="fas fa-calculator text-primary mr-2"></i> Total
                                            </label>
                                            <input type="text" class="form-control total" placeholder="Rp 0" readonly>
                                            <input type="hidden" name="jumlah[]" class="total-raw" value="0"> <!-- total asli (angka) -->
                                        </div>

                                        <!-- Tombol Hapus -->
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger remove-form" 
                                                style="display:none;">
                                            <i class="fas fa-trash mr-1"></i> Hapus Form
                                        </button>
                                    </div>

                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="card-footer bg-light d-flex justify-content-end" style="padding: 1.5rem 2rem;">
                                <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-secondary rounded-pill mr-2 px-4">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                </a>
                                @if(!isset($data))
                                <button type="button" class="btn btn-outline-danger rounded-pill mr-2 px-4" onclick="tambahForm()">
                                    <i class="fas fa-plus mr-2"></i>Tambah Form
                                </button>
                                @endif
                                <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                                    <i class="fas fa-{{ isset($data) ? 'save' : 'minus' }} mr-2"></i>
                                    {{ isset($data) ? 'PERBARUI' : 'SIMPAN' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                        <div class="card-header bg-gradient-warning text-white">
                            <h6 class="mb-0"><i class="fas fa-question-circle mr-2"></i>Bantuan</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-2">Isi semua field untuk menyimpan pengeluaran.</p>
                            <ul class="small mb-0">
                                <li>ID transaksi dibuat otomatis.</li>
                                <li>Tanggal transaksi wajib diisi.</li>
                                <li>Pilih nasabah dan jenis sampah (opsional).</li>
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

<!-- JS -->
<script>
    // Format angka ke ribuan dengan titik
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        if (!value) {
            input.value = '';
            return;
        }
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Event delegasi: semua input class 'jumlah' otomatis terformat
    document.addEventListener("input", e => {
        if (e.target.classList.contains("jumlah")) {
            formatCurrency(e.target);
        }
    });

    // Generate random ID transaksi
    function generateIdTransaksi() {
        const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        let result = "";
        for (let i = 0; i < 6; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    // Fungsi tambah form dinamis (bisa untuk pemasukan/pengeluaran)
    function tambahForm(containerId, formClass) {
        let container = document.getElementById(containerId);
        let firstForm = container.querySelector(`.${formClass}`);
        let newForm = firstForm.cloneNode(true);

        // reset input
        newForm.querySelectorAll('input,textarea').forEach(el => el.value = "");

        // generate id baru
        let idField = newForm.querySelector('input[name="id_transaksi[]"]');
        if (idField) idField.value = generateIdTransaksi();

        // tampilkan tombol hapus
        let removeBtn = newForm.querySelector('.remove-form');
        if (removeBtn) removeBtn.style.display = "inline-block";

        container.appendChild(newForm);
    }

    // Set ID transaksi pertama kali
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('input[name="id_transaksi[]"]').forEach(el => {
            if (!el.value) el.value = generateIdTransaksi();
        });
    });

    // Event hapus form
    document.addEventListener("click", e => {
        if (e.target.closest(".remove-form")) {
            e.target.closest(".pemasukan-form, .pengeluaran-form").remove();
        }
    });

    // Hitung total (jumlah × harga)
    function hitungTotal(jumlahInput) {
        let formGroup = $(jumlahInput).closest('.pengeluaran-form');
        let harga = parseInt(formGroup.find('.harga-sampah-raw').val() || 0);
        let jumlah = parseInt(jumlahInput.value.replace(/\./g, '') || 0);
        let total = harga * jumlah;

        // tampilkan hasil
        formGroup.find('.total').val("Rp " + total.toLocaleString('id-ID'));
        formGroup.find('.total-raw').val(total);
    }

    // Saat pilih jenis sampah → ambil harga
    $(document).on('change', '.jenis-sampah', function () {
        let id = $(this).val();
        let formGroup = $(this).closest('.pengeluaran-form');

        if (id) {
            $.get('/get-harga/' + id, function (data) {
                let harga = parseInt(data.harga || 0);

                formGroup.find('.harga-sampah').val("Rp " + harga.toLocaleString('id-ID'));
                formGroup.find('.harga-sampah-raw').val(harga);

                // Recalculate total kalau sudah isi jumlah
                let jumlahInput = formGroup.find('.jumlah').get(0);
                if (jumlahInput.value) hitungTotal(jumlahInput);
            });
        } else {
            formGroup.find('.harga-sampah').val('');
            formGroup.find('.harga-sampah-raw').val(0);
            formGroup.find('.total').val('');
            formGroup.find('.total-raw').val(0);
        }
    });

    // Saat user ketik jumlah → hitung ulang total
    $(document).on('keyup', '.jumlah', function () {
        hitungTotal(this);
    });

    document.addEventListener("DOMContentLoaded", () => {
    // Set ID transaksi pertama kali
    document.querySelectorAll('input[name="id_transaksi[]"]').forEach(el => {
        if (!el.value) el.value = generateIdTransaksi();
    });

    // 🔥 Auto isi harga kalau form edit sudah ada value jenis-sampah
    $('.pengeluaran-form').each(function () {
        let formGroup = $(this);
        let id = formGroup.find('.jenis-sampah').val();

        if (id) {
            $.get('/get-harga/' + id, function (data) {
                let harga = parseInt(data.harga || 0);

                formGroup.find('.harga-sampah').val("Rp " + harga.toLocaleString('id-ID'));
                formGroup.find('.harga-sampah-raw').val(harga);

                // Recalculate total kalau jumlah sudah ada
                let jumlahInput = formGroup.find('.jumlah').get(0);
                if (jumlahInput.value) hitungTotal(jumlahInput);
            });
        }
    });
});

</script>
@endsection
