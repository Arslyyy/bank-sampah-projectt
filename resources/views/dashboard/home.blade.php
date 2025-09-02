@extends('adminlte.layouts.app2')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gradient"
                        style="background: linear-gradient(45deg, #28a745, #20c997); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                        <i class="fas fa-recycle mr-2"></i>Transaksi Bank Sampah
                    </h1>
                    <p class="text-muted mb-0">Kelola transaksi sampah dengan mudah</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                        <li class="breadcrumb-item"><a href="#" class="text-success"><i class="fas fa-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item active text-secondary">List Transaksi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Info Cards -->
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-gradient-success shadow-lg border-0 text-center">
                        <div class="card-body text-white">
                            <h5>Total Transaksi</h5>
                            <h3>{{ $datas->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-gradient-info shadow-lg border-0 text-center">
                        <div class="card-body text-white">
                            <h5>Bulan Ini</h5>
                            <h3>{{ $datas->where('tanggal_transaksi', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-gradient-warning shadow-lg border-0 text-center">
                        <div class="card-body text-white">
                            <h5>Jenis Sampah</h5>
                            <h3>{{ $datas->groupBy('master_jenis_sampah_id')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0" style="border-radius: 15px;">
                        <div class="card-header bg-gradient-primary text-white">
                            <h3 class="card-title"><i class="fas fa-database mr-2"></i>Data Transaksi</h3>
                        </div>

                        <div class="card-body bg-light pb-2">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select class="form-control" id="filterJenis">
                                        <option value="">Semua Jenis Sampah</option>
                                        @foreach ($datas->groupBy('master_jenis_sampah_id') as $id => $items)
                                            <option value="{{ $items->first()->jenisSampah->type_sampah ?? '-' }}">
                                                {{ $items->first()->jenisSampah->type_sampah ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" id="filterTanggal" placeholder="Filter Tanggal">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-outline-secondary btn-block" onclick="clearFilters()">
                                        <i class="fas fa-eraser"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table id="tabel_home" class="table table-hover table-borderless">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Nasabah</th>
                                            <th>Jenis Sampah</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($datas as $val)
                                        <tr>
                                            <td>{{ $val->tanggal_transaksi->format('d/m/Y') }}</td>
                                            <td>{{ Auth::user()->name }}</td>
                                            <td>{{ $val->jenisSampah->type_sampah ?? '-' }}</td>
                                            <td>{{ 'Rp ' . number_format($val->jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                Belum ada data transaksi.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($datas->count() > 0)
                        <div class="card-footer bg-light text-right">
                            Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}
                        </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        let table = $('#tabel_home').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "paging": true,
        });

        $('#filterJenis').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        $('#filterTanggal').on('change', function() {
            let selectedDate = this.value;
            if (selectedDate) {
                let formattedDate = new Date(selectedDate).toLocaleDateString('id-ID');
                table.column(0).search(formattedDate).draw();
            } else {
                table.column(0).search('').draw();
            }
        });
    });

    function clearFilters() {
        $('#filterJenis').val('');
        $('#filterTanggal').val('');
        $('#tabel_home').DataTable().search('').columns().search('').draw();
    }
</script>
@endsection
