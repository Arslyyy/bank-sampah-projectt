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
                                            {{ 'Rp ' . number_format($totalPengeluaran, 0, ',', '.') }}</h4>
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-0"><i class="fas fa-history mr-2"></i>Transaksi Terbaru
                                        </h3>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <!-- Filter Form -->
                                        <form method="GET" action="{{ url()->current() }}" class="form-inline mr-3">
                                            <div class="input-group input-group-sm">
                                                <select name="jenis_sampah" class="form-control"
                                                    onchange="this.form.submit()">
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
                                                        <a href="{{ url()->current() }}"
                                                            class="btn btn-outline-light btn-sm">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                        <span class="badge badge-light">{{ $transaksiTerbaruData->count() }}
                                            transaksi</span>
                                    </div>
                                </div>
                            </div>
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
    </div>

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
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            label: 'Pemasukan',
                            data: {!! json_encode($chartData['pemasukan']) !!},
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
