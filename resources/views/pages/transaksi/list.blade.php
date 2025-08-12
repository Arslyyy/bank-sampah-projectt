
@extends('adminlte.layouts.app')


@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid mb-2">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Data Transaksi</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- flash message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th class="text-right">Jumlah</th>
                                <th>Uraian/Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $val)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($val->jenis == 'pemasukan')
                                            <span class="badge badge-success">Pemasukan</span>
                                        @elseif($val->jenis == 'pengeluaran')
                                            <span class="badge badge-danger">Pengeluaran</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($val->jenis) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $val->satuan->satuan ?? '-' }}</td>
                                    <td class="text-right">
                                        {{ $val->jumlah !== null ? 'Rp ' . number_format($val->jumlah, 0, ',', '.') : '-' }}
                                    </td>
                                    <td>{{ $val->uraian ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
