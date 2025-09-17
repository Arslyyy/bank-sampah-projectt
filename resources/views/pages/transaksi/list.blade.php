@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header pb-3 border-bottom border-info">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-info">
                        <i class="fas fa-file-invoice-dollar mr-2"></i> Pelaporan
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- flash message --}}
            @if(session('success'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm rounded" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Filter Nama Nasabah, Bulan & Tahun --}}
            <div class="card shadow-sm mb-4 border-info">
                <div class="card-body">
                    <form method="GET" action="{{ route('transaksi.index') }}" class="form-row align-items-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label for="nasabah" class="font-weight-bold text-info">Cari Nama Nasabah</label>
                            <input type="text" name="nasabah" id="nasabah" 
                                class="form-control form-control-sm shadow-sm"
                                value="{{ request('nasabah') }}" placeholder="Ketik nama nasabah...">
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label for="bulan" class="font-weight-bold text-info">Pilih Bulan</label>
                            <select name="bulan" id="bulan" class="form-control form-control-sm shadow-sm">
                                <option value="">-- Semua Bulan --</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label for="tahun" class="font-weight-bold text-info">Pilih Tahun</label>
                            <select name="tahun" id="tahun" class="form-control form-control-sm shadow-sm">
                                <option value="">-- Semua Tahun --</option>
                                @for ($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4 mt-4 mt-md-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-info btn-sm shadow-sm mr-2 px-4">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm px-4 shadow-sm">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </div>
                    </form>

                    {{-- Tombol Download --}}
                    @if(request()->filled('bulan'))
                        <div class="mt-3">
                            <a href="{{ route('transaksi.export', request()->all()) }}"
                               class="btn btn-success btn-sm shadow-sm mr-2">
                                <i class="fas fa-file-excel mr-1"></i> Download Excel
                            </a>
                            <a href="{{ route('transaksi.exportPdf', request()->all()) }}" 
                               class="btn btn-danger btn-sm shadow-sm">
                                <i class="fas fa-file-pdf mr-1"></i> Download PDF
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Table --}}
            <div class="card shadow-sm border-info rounded-lg">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped mb-0 text-nowrap align-middle">
                        <thead class="bg-info text-white text-uppercase small">
                            <tr>
                                <th style="width: 60px;"><i class="fas fa-hashtag"></i> No</th>
                                <th style="width: 80px;"><i class="fas fa-receipt"></i> ID</th>
                                <th style="min-width: 180px;"><i class="fas fa-user"></i> Nasabah</th>
                                <th style="min-width: 120px;"><i class="fas fa-calendar-alt"></i> Tanggal</th>
                                <th style="min-width: 120px;"><i class="fas fa-random"></i> Jenis</th>
                                <th class="text-right" style="min-width: 140px;"><i class="fas fa-coins"></i> Jumlah</th>
                                <th style="min-width: 220px;"><i class="fas fa-sticky-note"></i> Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $val)
                                <tr>
                                    <td class="text-center font-weight-bold">
                                        {{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}
                                    </td>
                                    <td class="font-monospace text-primary">
                                        <i class="fas fa-barcode mr-1"></i>{{ $val->id_transaksi }}
                                    </td>
                                    <td>{{ $val->nasabah->nama ?? '-' }}</td>
                                    <td class="font-monospace">
                                        <i class="fas fa-clock text-muted mr-1"></i>
                                        {{ \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @if($val->jenis == 'pemasukan')
                                            <span class="badge badge-success px-3 py-2 shadow-sm">
                                                <i class="fas fa-arrow-down mr-1"></i>Pemasukan
                                            </span>
                                        @elseif($val->jenis == 'pengeluaran')
                                            <span class="badge badge-danger px-3 py-2 shadow-sm">
                                                <i class="fas fa-arrow-up mr-1"></i>Pengeluaran
                                            </span>
                                        @else
                                            <span class="badge badge-secondary px-3 py-2 shadow-sm">
                                                <i class="fas fa-exchange-alt mr-1"></i>{{ ucfirst($val->jenis) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-right font-weight-bold 
                                        {{ $val->jenis == 'pemasukan' ? 'text-success' : ($val->jenis == 'pengeluaran' || $val->jenis == 'operasional' ? 'text-danger' : '') }}">
                                        {{ $val->jumlah !== null ? 'Rp ' . number_format($val->jumlah, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-truncate" style="max-width: 280px;">
                                        <i class="fas fa-quote-left text-muted mr-1"></i>{{ $val->uraian ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5 font-italic">
                                        <i class="fas fa-info-circle"></i> Belum ada data transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination + Total --}}
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        {{ $data->links() }}
                    </div>

                    {{-- Total transaksi --}}
                    @if(request()->filled('bulan') || request()->filled('tahun'))
                        <div class="bg-light border rounded px-4 py-2 shadow-sm mt-3 mt-md-0">
                            <span class="mr-4">
                                <i class="fas fa-arrow-down text-success"></i> 
                                Pemasukan: 
                                <span class="text-success font-weight-bold">
                                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                                </span>
                            </span>
                            <span class="mr-4">
                                <i class="fas fa-arrow-up text-danger"></i> 
                                Pengeluaran: 
                                <span class="text-danger font-weight-bold">
                                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                                </span>
                            </span>
                            <span class="mr-4">
                                <i class="fas fa-cogs text-warning"></i> 
                                Operasional: 
                                <span class="text-warning font-weight-bold">
                                    Rp {{ number_format($totalOperasional, 0, ',', '.') }}
                                </span>
                            </span>
                            <span>
                                <i class="fas fa-wallet text-primary"></i> 
                                Sisa Saldo: 
                                <span class="{{ $sisaSaldo >= 0 ? 'text-primary' : 'text-danger' }} font-weight-bold">
                                    Rp {{ number_format($sisaSaldo, 0, ',', '.') }}
                                </span>
                            </span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
</div>

<style>
    .table thead th {
        font-weight: 700;
        letter-spacing: .5px;
    }
    .table-hover tbody tr:hover {
        background-color: #f1faff !important;
        transition: background-color 0.3s ease;
    }
    .badge {
        font-size: 0.8rem;
        border-radius: 0.4rem;
    }
    .table td, .table th {
        padding: 0.75rem 1rem;
        vertical-align: middle;
    }
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection
