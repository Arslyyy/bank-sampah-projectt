@extends('adminlte.layouts.app')

{{-- Judul Halaman --}}
@section('title', 'Harga Sampah')

{{-- Konten Utama Halaman --}}
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-gradient"
                            style="background: linear-gradient(45deg, #17a2b8, #007bff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                            <i class="fas fa-tags mr-2"></i>Harga Sampah
                        </h1>
                        <p class="text-muted mb-0">Kelola harga sampah per jenis dan satuan</p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                            <li class="breadcrumb-item"><a href="#" class="text-info"><i class="fas fa-home"></i>
                                    Dashboard</a></li>
                            <li class="breadcrumb-item active text-secondary">List Harga Sampah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-info shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Total Jenis</h5>
                                        <h3 class="mb-0">{{ $datas->count() }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-recycle fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-success shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Harga Tertinggi</h5>
                                        <h3 class="mb-0">Rp
                                            {{ number_format($datas->max('harga_sampah') ?? 0, 0, ',', '.') }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-arrow-up fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-warning shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Harga Terendah</h5>
                                        <h3 class="mb-0">Rp
                                            {{ number_format($datas->min('harga_sampah') ?? 0, 0, ',', '.') }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-arrow-down fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-purple shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Rata-rata Harga</h5>
                                        <h3 class="mb-0">Rp
                                            {{ number_format($datas->avg('harga_sampah') ?? 0, 0, ',', '.') }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-chart-bar fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-header bg-gradient-info text-white" style="border-radius: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-1">
                                            <i class="fas fa-list-ul mr-2"></i>Data Harga Sampah
                                        </h3>
                                    </div>
                                    <div class="card-tools">
                                        <a href="/admin/bank/harga/create" class="text-decoration-none">
                                            <button class="btn btn-light btn-sm rounded-pill shadow-sm" type="button">
                                                <i class="fas fa-plus mr-1"></i> Tambah Data
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body bg-light pb-2">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0">
                                                    <i class="fas fa-search text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control border-left-0" id="searchInput"
                                                placeholder="Cari jenis sampah atau harga...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control custom-select" id="sortPrice">
                                            <option value="">Urutkan Harga</option>
                                            <option value="asc">Harga Terendah</option>
                                            <option value="desc">Harga Tertinggi</option>
                                        </select>
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
                                    <table id="semua_tabel" class="table table-hover table-borderless">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm">
                                                    <i class="fas fa-recycle text-success mr-1"></i>Jenis / Type Sampah
                                                </th>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm">
                                                    <i class="fas fa-money-bill text-warning mr-1"></i>Harga
                                                </th>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm text-center">
                                                    <i class="fas fa-cogs text-info mr-1"></i>Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($datas as $index => $val)
                                                <tr class="table-row-hover" style="transition: all 0.2s ease;">
                                                    <td class="py-4">
                                                        <div class="d-flex align-items-center">
                                                            @php
                                                                $iconColors = [
                                                                    'primary',
                                                                    'success',
                                                                    'info',
                                                                    'warning',
                                                                    'secondary',
                                                                ];
                                                                $colorIndex = $index % count($iconColors);
                                                            @endphp
                                                            <div class="bg-{{ $iconColors[$colorIndex] }} text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                                style="width: 45px; height: 45px;">
                                                                <i class="fas fa-leaf"></i>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold text-lg">
                                                                    {{ $val->jenis_sampah->type_sampah ?? 'Jenis Tidak Diketahui' }}
                                                                </div>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-tag mr-1"></i>Kategori:
                                                                    {{ ucfirst($val->jenis_sampah->type_sampah ?? 'N/A') }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4" data-order="{{ $val->harga_sampah }}">
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="fas fa-dollar-sign"></i>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold text-success text-lg">
                                                                    Rp {{ number_format($val->harga_sampah, 0, ',', '.') }}
                                                                </div>
                                                                <small class="text-muted text-uppercase">
                                                                    <i class="fas fa-balance-scale mr-1"></i>
                                                                    per {{ $val->satuan->satuan ?? 'Unit' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ url('admin/bank/harga/edit/' . $val->id) }}"
                                                                class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                                                title="Edit Data">
                                                                <i class="fas fa-edit mr-1"></i> Edit
                                                            </a>
                                                            <button
                                                                class="btn btn-outline-info btn-sm rounded-pill px-3 ml-1"
                                                                onclick="viewDetail({{ $val->id }})"
                                                                title="Lihat Detail">
                                                                <i class="fas fa-eye mr-1"></i> Detail
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                                                            <h5 class="text-muted">Belum Ada Data Harga</h5>
                                                            <p class="text-muted mb-3">Tambahkan harga sampah untuk memulai
                                                            </p>
                                                            <a href="/bank/harga/create"
                                                                class="btn btn-primary rounded-pill">
                                                                <i class="fas fa-plus mr-1"></i> Tambah Harga Pertama
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if ($datas->count() > 0)
                                <div class="card-footer bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Total {{ $datas->count() }} jenis sampah terdaftar
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <small class="text-muted">
                                                <i class="fas fa-clock mr-1"></i>
                                                Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-info text-white">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-info-circle mr-2"></i>Detail Harga Sampah
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <style>
        .bg-gradient-purple {
            background: linear-gradient(87deg, #8965e0 0, #bc65e0 100%) !important;
        }

        .table-row-hover:hover {
            background-color: #f8f9fa !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .empty-state {
            padding: 3rem;
        }

        .text-gradient {
            font-size: 1.8rem;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .modal-content {
            border-radius: 15px;
        }

        .text-success.text-lg {
            font-size: 1.1rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .text-gradient {
                font-size: 1.4rem;
            }

            .card-body .row.mb-3>div {
                margin-bottom: 0.5rem;
            }

            .btn-group {
                display: flex;
                flex-direction: column;
            }

            .btn-group .btn {
                margin: 2px 0;
            }
        }
    </style>
@endpush


@push('scripts')
    <script>
        // Fungsi global agar bisa dipanggil oleh onclick
        function clearFilters() {
            $('#searchInput').val('');
            $('#sortPrice').val('');
            $('#semua_tabel').DataTable().search('').order([1, 'desc']).draw();
        }

        function viewDetail(id) {
            $('#detailContent').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>
                    <p class="mt-2 text-muted">Memuat detail...</p>
                </div>
            `);
            $('#detailModal').modal('show');
            // Ganti dengan AJAX call ke backend Anda
            setTimeout(() => {
                $('#detailContent').html(`
                    <div class="alert alert-info"><i class="fas fa-info-circle mr-2"></i>Detail lengkap harga sampah ID: ${id}</div>
                    <p>Informasi detail akan ditampilkan di sini setelah integrasi dengan API backend.</p>
                `);
            }, 1000);
        }

        // Kode jQuery yang dijalankan setelah halaman siap
        $(document).ready(function() {
            // Inisialisasi DataTable
            let table = $('#semua_tabel').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": true,
                "info": true,
                "paging": true,
                "pageLength": 10,
                "dom": 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>', // DOM yang lebih baik untuk info & pagination
                "order": [
                    [1, "desc"]
                ], // Default sort by price descending
                "columnDefs": [{
                        "targets": [2],
                        "orderable": false
                    } // Kolom action tidak bisa di-sort
                ],
                "language": {
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "→",
                        "previous": "←"
                    },
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 data",
                    "infoFiltered": "(difilter dari _MAX_ total data)"
                }
            });

            // Fungsionalitas pencarian kustom
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Fungsionalitas urutkan harga
            $('#sortPrice').on('change', function() {
                let sortOrder = this.value;
                if (sortOrder) {
                    table.order([1, sortOrder]).draw();
                }
            });
        });

        // Animasi saat load
        $(window).on('load', function() {
            $('.card').each(function(i) {
                $(this).delay(i * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 500);
            });
        });
    </script>
@endpush
