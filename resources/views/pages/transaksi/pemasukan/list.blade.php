{{-- resources/views/pages/transaksi/pemasukan/list.blade.php --}}
@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid mb-2">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Daftar Pemasukan</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('pemasukkan.create') }}" class="btn btn-primary">Tambah Pemasukan</a>
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
                                <th>Satuan</th>
                                <th class="text-right">Jumlah</th>
                                <th>Uraian/Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $val)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y') }}</td>
                                <td>{{ $val->satuan->satuan ?? '-' }}</td>
                                <td class="text-right">{{ $val->jumlah !== null ? 'Rp ' . number_format($val->jumlah, 0, ',', '.') : '-' }}</td>
                                <td>{{ $val->uraian ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('pemasukkan.edit', $val->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ url('transaksi/pemasukkan/delete/'.$val->id) }}"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')"
                                       class="btn btn-sm btn-danger">Hapus</a>
                                </td>
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
