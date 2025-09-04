@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header pb-3 border-bottom border-info">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-info"><i class="fas fa-file-invoice-dollar mr-2"></i>Data Transaksi</h1>
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

            {{-- Filter Nama Nasabah,Bulan & Tahun --}}
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
                            <button type="submit" class="btn btn-info btn-sm shadow-sm mr-2 px-4">Filter</button>
                            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm px-4 shadow-sm">Reset</a>
                        </div>
                    </form>

                    {{-- Tombol Download Excel --}}
                    @if(request()->filled('bulan'))
                        <div class="mt-2">
                            <a href="{{ route('transaksi.export', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                               class="btn btn-info shadow-sm">
                                <i class="fas fa-file-excel mr-1"></i> Download Excel
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Table --}}
            <div class="card shadow-sm border-info rounded-lg">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped mb-0 text-nowrap">
                        <thead class="bg-info text-white text-uppercase small">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th style="width: 60px;">Id Transaksi</th>
                                <th style="min-width: 180px;">Nama Nasabah</th>
                                <th style="min-width: 110px;">Tanggal</th>
                                <th style="min-width: 120px;">Jenis</th>
                                <th class="text-right" style="min-width: 140px;">Jumlah</th>
                                <th style="min-width: 200px;">Uraian/Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $val)
                                <tr>
                                    <td class="align-middle font-weight-bold">{{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}</td>
                                    <td class="align-middle font-monospace">
                                        <i class="fas fa-receipt text-primary mr-1"></i> {{ $val->id_transaksi }}
                                    </td>
                                    <td class="align-middle">{{ $val->nasabah->nama ?? '-' }}</td>
                                    <td class="align-middle font-monospace">{{ \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y') }}</td>
                                    <td class="align-middle">
                                        @if($val->jenis == 'pemasukan')
                                            <span class="badge badge-success px-3 py-2 shadow-sm">Pemasukan</span>
                                        @elseif($val->jenis == 'pengeluaran')
                                            <span class="badge badge-danger px-3 py-2 shadow-sm">Pengeluaran</span>
                                        @else
                                            <span class="badge badge-secondary px-3 py-2 shadow-sm">{{ ucfirst($val->jenis) }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-right font-weight-bold 
                                        {{ $val->jenis == 'pemasukan' ? 'text-success' : ($val->jenis == 'pengeluaran' ? 'text-danger' : '') }}">
                                        {{ $val->jumlah !== null ? 'Rp ' . number_format($val->jumlah, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="align-middle text-truncate" style="max-width: 280px;">{{ $val->uraian ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5 font-italic">
                                        <i class="fas fa-info-circle"></i> Belum ada data transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        {{ $data->links() }}
                    </div>

                    {{-- Total transaksi --}}
                    @if(request()->filled('bulan') || request()->filled('tahun'))
                        @php
                            $sisaSaldo = $totalPemasukan - $totalPengeluaran;
                        @endphp
                        <div class="font-weight-bold text-dark mt-3 mt-md-0">
                            <span class="mr-4">
                                Total Pemasukan: 
                                <span class="text-success">
                                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                                </span>
                            </span>
                            <span class="mr-4">
                                Total Pengeluaran: 
                                <span class="text-danger">
                                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                                </span>
                            </span>
                            <span>
                                Sisa Saldo: 
                                <span class="{{ $sisaSaldo >= 0 ? 'text-primary' : 'text-warning' }}">
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
    .font-monospace {
        font-family: 'Courier New', Courier, monospace;
    }
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table-hover tbody tr:hover {
        background-color: #e0f7fa !important; /* biru muda */
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .badge {
        font-size: 0.9rem;
        border-radius: 0.4rem;
        font-weight: 600;
    }
    .alert {
        font-size: 1rem;
        border-radius: 0.3rem;
    }
    .btn-outline-secondary:hover {
        background-color: #d6d6d6;
        transition: background-color 0.3s ease;
    }
    form .form-control:focus {
        box-shadow: 0 0 8px #17a2b8; /* biru info */
        border-color: #17a2b8;
        outline: none;
    }
</style>
@endsection
