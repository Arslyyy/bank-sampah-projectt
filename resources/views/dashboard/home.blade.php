@extends('adminlte.layouts.app2')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid mb-3">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gradient"
                        style="background: linear-gradient(45deg, #28a745, #20c997); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Nasabah
                    </h1>
                    <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                        <li class="breadcrumb-item active text-secondary">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Summary Cards -->
            <div class="row mb-4">
                <!-- Total Transaksi -->
                <div class="col-lg-4 col-md-6">
                    <div class="card bg-gradient-primary shadow-lg border-0 rounded-lg">
                        <div class="card-body text-white text-center">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="font-weight-bold mb-0">{{ $totalTransaksi }}</h3>
                                    <small>Total Transaksi</small>
                                </div>
                                <div>
                                    <i class="fas fa-exchange-alt fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaksi Bulan Ini -->
                <div class="col-lg-4 col-md-6">
                    <div class="card bg-gradient-success shadow-lg border-0 rounded-lg">
                        <div class="card-body text-white text-center">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="font-weight-bold mb-0">{{ $transaksiBulanIni }}</h3>
                                    <small>Bulan Ini</small>
                                </div>
                                <div>
                                    <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pemasukan -->

                <!-- Total Pengeluaran -->
                <div class="col-lg-4 col-md-6">
                    <div class="card bg-gradient-warning shadow-lg border-0 rounded-lg">
                        <div class="card-body text-white text-center">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="font-weight-bold mb-0">
                                        {{ 'Rp ' . number_format($totalPengeluaran, 0, ',', '.') }}
                                    </h4>
                                    <small>Total Pemasukan</small>
                                </div>
                                <div>
                                    <i class="fas fa-arrow-down fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saldo Card -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div
                        class="card {{ $saldo >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }} shadow-lg border-0 rounded-lg">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="font-weight-bold mb-0">{{ 'Rp ' . number_format($saldo, 0, ',', '.') }}
                                    </h2>
                                    <p class="mb-0">Saldo Anda</p>
                                </div>
                                <div>
                                    <i class="fas fa-wallet fa-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-gradient-secondary shadow-lg border-0 rounded-lg">
                        <div class="card-body text-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="font-weight-bold mb-0">{{ $jenisTransaksi }}</h3>
                                    <p class="mb-0">Jenis Sampah Berbeda</p>
                                </div>
                                <div>
                                    <i class="fas fa-recycle fa-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-gradient-dark text-white">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                                <!-- Judul -->
                                <div class="mb-2 mb-sm-0">
                                    <h3 class="card-title mb-0">
                                        <i class="fas fa-history mr-2"></i>Transaksi Terbaru
                                    </h3>
                                </div>

                                <!-- Filter + Tombol -->
                                <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center">
                                    <!-- Filter Form -->
                                    <form method="GET" action="{{ url()->current() }}"
                                        class="form-inline mb-2 mb-sm-0 mr-sm-3 w-100 w-sm-auto">
                                        <div class="input-group input-group-sm w-100">
                                            <select name="jenis_sampah" class="form-control" onchange="this.form.submit()">
                                                <option value="">Semua Jenis Sampah</option>
                                                @foreach ($jenisSampahList as $jenisSampah)
                                                <option value="{{ $jenisSampah->id }}"
                                                    {{ $filterJenisSampah == $jenisSampah->id ? 'selected' : '' }}>
                                                    {{ $jenisSampah->type_sampah }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                @if ($filterJenisSampah)
                                                <a href="{{ url()->current() }}" class="btn btn-outline-light btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Tombol Nota -->
                                    <button type="button" class="btn btn-secondary btn-sm shadow-sm w-100 w-sm-auto"
                                        data-toggle="modal" data-target="#notaModal">
                                        <i class="fas fa-file-alt"></i> Nota
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- <span class="badge badge-light">{{ $transaksiTerbaruData->count() }}
                                        transaksi</span> -->
                        <div class="card-body p-0">
                            @if ($transaksiTerbaruData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis Sampah</th>
                                            <th>Satuan</th>
                                            <th>Berat</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksiTerbaruData as $transaksi)
                                        <tr>
                                            <td>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}</small>
                                            </td>
                                            <td>
                                                <span
                                                    class="font-weight-bold">{{ $transaksi->jenisSampah->type_sampah ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-secondary">{{ $transaksi->satuan->satuan ?? '-' }}</span>
                                            </td>
                                            <td>{{ number_format($transaksi->jumlah_berat, 2) }}</td>
                                            <td class="text-right font-weight-bold text-success">
                                                {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                @if ($filterJenisSampah)
                                <h5 class="text-muted">Tidak ada transaksi untuk jenis sampah yang dipilih</h5>
                                <p class="text-muted">Coba pilih jenis sampah yang lain atau hapus filter</p>
                                @else
                                <h5 class="text-muted">Belum ada transaksi</h5>
                                <p class="text-muted">Transaksi Anda akan muncul di sini</p>
                                @endif
                            </div>
                            @endif
                        </div>
                        @if ($transaksiTerbaruData->count() > 0)
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Menampilkan {{ $transaksiTerbaruData->count() }} transaksi terbaru
                                    @if ($filterJenisSampah)
                                    untuk
                                    {{ $jenisSampahList->where('id', $filterJenisSampah)->first()->type_sampah ?? 'jenis sampah terpilih' }}
                                    @endif
                                </small>
                                @if ($filterJenisSampah)
                                <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times mr-1"></i> Hapus Filter
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chart Section (Optional) -->

            <!-- Chart Section (Optional) -->
            @if ($chartData)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-gradient-info text-white">
                            <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Grafik Transaksi 4 Minggu
                                Terakhir</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="transactionChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel"><i
                            class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                    <h5>Yakin ingin menghapus?</h5>
                    <p class="text-muted" id="deleteText"></p>
                    <div class="alert alert-warning mt-3"><i
                            class="fas fa-exclamation-triangle mr-2"></i><strong>Peringatan:</strong> Data yang dihapus
                        tidak dapat dikembalikan!</div>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger rounded-pill"><i
                                class="fas fa-trash mr-1"></i>Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Nota --}}
    <div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="notaModalLabel"><i class="fas fa-file-alt mr-2"></i> Tampilkan Nota Pengeluaran</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="notaForm">
                    <div class="modal-body">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nasabah_id">Nama Nasabah</label>
                                <select name="nasabah_id" id="nasabah_id" class="form-control" required disabled>
                                    <option value="{{ Auth::user()->nasabah_id }}" selected>{{ Auth::user()->name }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Area Nota -->
                        <div id="notaResult" class="mt-3" style="max-height:400px; overflow:auto;">
                            <!-- Hasil nota akan muncul di sini -->
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info rounded-pill"><i class="fas fa-search mr-1"></i> Tampilkan Nota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Ganti dengan library yang diperlukan untuk PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                let text = this.getAttribute('data-text');
                document.getElementById('deleteText').textContent = text;
                document.getElementById('deleteForm').setAttribute('action', '/admin/transaksi/pengeluaran/delete/' + id);
                $('#deleteModal').modal('show');
            });
        });
    });

    // NOTA - dengan download PDF
    document.getElementById('notaForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let nasabahId = document.getElementById('nasabah_id').value;
        let tanggal = document.getElementById('tanggal').value;
        let token = document.querySelector('input[name="_token"]').value;

        fetch("{{ route('nota.show') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    nasabah_id: nasabahId,
                    tanggal: tanggal
                })
            })
            .then(res => res.json())
            .then(data => {
                let html = '';
                if (data.length > 0) {
                    html += `<div id="notaContent" class="p-3 border rounded shadow-sm" style="background:#fff;">
                    <h4 class="text-center mb-3">Nota Bank Sampah</h4>
                    <p><strong>Nasabah:</strong> ${document.getElementById('nasabah_id').selectedOptions[0].text}</p>
                    <p><strong>Tanggal:</strong> ${tanggal}</p>
                    <table class="table table-bordered table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Transaksi</th>
                                <th>Jenis Sampah</th>
                                <th>Berat (kg)</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    let totalJumlah = 0;
                    data.forEach((row, index) => {
                        totalJumlah += Number(row.jumlah) || 0;
                        html += `<tr>
                        <td>${index+1}</td>
                        <td>${row.id_transaksi}</td>
                        <td>${row.jenis_sampah?.type_sampah ?? '-'}</td>
                        <td>${row.jumlah_berat}</td>
                        <td>${row.jumlah ? 'Rp ' + Number(row.jumlah).toLocaleString('id-ID') : '-'}</td>
                     </tr>`;
                    });
                    html += `</tbody></table>
                 <h5 class="text-right mt-2">Total: Rp ${totalJumlah.toLocaleString('id-ID')}</h5>
                 <p class="text-center text-muted small mt-3">Terima kasih atas transaksi Anda!</p>
                 <button id="downloadNota" class="btn btn-success btn-sm mt-2" 
                    data-nasabah="${nasabahId}" data-tanggal="${tanggal}">
                    <i class="fas fa-download"></i> Unduh Nota (PDF)
                 </button>
                 </div>`;
                } else {
                    html = '<p class="text-center text-muted">Tidak ada transaksi ditemukan untuk nasabah dan tanggal tersebut.</p>';
                }
                document.getElementById('notaResult').innerHTML = html;

                // Tambahkan event listener untuk download PDF
                document.getElementById('downloadNota')?.addEventListener('click', function() {
                    const nasabahId = this.getAttribute('data-nasabah');
                    const tanggal = this.getAttribute('data-tanggal');
                    const nasabahName = document.getElementById('nasabah_id').selectedOptions[0].text;

                    // Sembunyikan tombol sementara
                    this.style.display = 'none';

                    // Gunakan html2canvas untuk menangkap konten sebagai gambar
                    html2canvas(document.getElementById('notaContent'), {
                        scale: 2,
                        useCORS: true,
                        logging: false
                    }).then(canvas => {
                        // Kembalikan tombol
                        this.style.display = 'inline-block';

                        // Buat PDF
                        const imgData = canvas.toDataURL('image/jpeg', 1.0);
                        const {
                            jsPDF
                        } = window.jspdf;
                        const doc = new jsPDF('p', 'mm', 'a4');

                        const pageWidth = doc.internal.pageSize.getWidth();
                        const pageHeight = doc.internal.pageSize.getHeight();

                        // Hitung dimensi gambar untuk muat di halaman PDF
                        const imgWidth = pageWidth - 20; // Margin 10mm di kiri dan kanan
                        const imgHeight = (canvas.height * imgWidth) / canvas.width;

                        // Tambahkan gambar ke PDF
                        doc.addImage(imgData, 'JPEG', 10, 10, imgWidth, imgHeight);

                        // Simpan PDF
                        doc.save(`nota_${nasabahName}_${tanggal}.pdf`);
                    });
                });
            });
    });
</script>
@endpush

<style>
    .opacity-75 {
        opacity: 0.75;
    }

    .text-gradient {
        background: linear-gradient(45deg, #28a745, #20c997);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: bold;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, .075);
    }

    .input-group-sm .form-control {
        min-width: 200px;
    }
</style>

@if ($chartData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('transactionChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {
                    !!json_encode($chartData['labels']) !!
                },
                datasets: [{
                    label: 'Pemasukan',
                    data: {
                        !!json_encode($chartData['pemasukan']) !!
                    },
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    fill: false
                }, ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Transaksi Mingguan (4 Minggu Terakhir)'
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Minggu'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    });
</script>
@endif
@endsection