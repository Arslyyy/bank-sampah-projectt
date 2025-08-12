@extends('adminlte.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
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
                            <li class="breadcrumb-item"><a href="#" class="text-success"><i class="fas fa-home"></i>
                                    Dashboard</a></li>
                            <li class="breadcrumb-item active text-secondary">List Transaksi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info Cards Row -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-success shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Total Transaksi</h5>
                                        <h3 class="mb-0">{{ $datas->count() }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-chart-line fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-info shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Bulan Ini</h5>
                                        <h3 class="mb-0">
                                            {{ $datas->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
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
                                        <h5 class="mb-1">Jenis Sampah</h5>
                                        <h3 class="mb-0">{{ $datas->groupBy('jenis_sampah_id')->count() }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-trash-alt fa-2x opacity-75"></i>
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
                                        <h5 class="mb-1">Nasabah Aktif</h5>
                                        <h3 class="mb-0">{{ $datas->groupBy('nasabah_id')->count() }}</h3>
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-users fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Table Card -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                            <!-- Enhanced Card Header -->
                            <div class="card-header bg-gradient-primary text-white" style="border-radius: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-1">
                                            <i class="fas fa-database mr-2"></i>Data Transaksi Bank Sampah
                                        </h3>
                                    </div>
                                    <div class="card-tools">
                                        <button class="btn btn-light btn-sm rounded-pill" onclick="refreshTable()">
                                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Search & Filter Section -->
                            <div class="card-body bg-light pb-2">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0">
                                                    <i class="fas fa-search text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control border-left-0" id="searchInput"
                                                placeholder="Cari nasabah, jenis sampah...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control custom-select" id="filterJenis">
                                            <option value="">Semua Jenis Sampah</option>
                                            @foreach ($datas->groupBy('jenis_sampah.type_sampah') as $jenis => $items)
                                                <option value="{{ $jenis }}">{{ $jenis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" id="filterTanggal"
                                            placeholder="Filter Tanggal">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-outline-secondary btn-block" onclick="clearFilters()">
                                            <i class="fas fa-eraser"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Table -->
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table id="tabel_home" class="table table-hover table-borderless">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm">
                                                    <i class="fas fa-calendar text-primary mr-1"></i>Tanggal
                                                </th>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm">
                                                    <i class="fas fa-user text-success mr-1"></i>Nama Nasabah
                                                </th>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm">
                                                    <i class="fas fa-recycle text-warning mr-1"></i>Jenis Sampah
                                                </th>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm">
                                                    <i class="fas fa-weight text-info mr-1"></i>Jumlah
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($datas as $index => $val)
                                                <tr class="table-row-hover" style="transition: all 0.2s ease;">
                                                    <td class="py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                                style="width: 40px; height: 40px;">
                                                                <strong>{{ $val->tanggal_transaksi ? \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y H:i A') : '' }}</strong>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold">
                                                                    {{ $val->tanggal_transaksi ? \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y H:i A') : '' }}
                                                                </div>
                                                                <small class="text-muted">
                                                                    {{ $val->tanggal_transaksi ? \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y H:i A') : '' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                                style="width: 35px; height: 35px;">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-medium">
                                                                    {{ $val->nasabah->nama ?? 'Data tidak tersedia' }}
                                                                </div>
                                                                @if ($val->nasabah)
                                                                    <small class="text-muted">ID:
                                                                        {{ $val->nasabah->id }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        @php
                                                            $badgeColors = [
                                                                'primary',
                                                                'success',
                                                                'info',
                                                                'warning',
                                                                'secondary',
                                                            ];
                                                            $colorIndex = $index % count($badgeColors);
                                                        @endphp
                                                        <span
                                                            class="badge badge-{{ $badgeColors[$colorIndex] }} badge-pill px-3 py-2 font-weight-normal">
                                                            <i class="fas fa-recycle mr-1"></i>
                                                            {{ $val->jenis_sampah->type_sampah ?? 'Tidak Diketahui' }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                                style="width: 35px; height: 35px;">
                                                                <i class="fas fa-weight-hanging"></i>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold text-lg">
                                                                    {{ number_format($val->satuans, 1) }}
                                                                </div>
                                                                <small class="text-muted text-uppercase">
                                                                    {{ $val->satuan->satuan ?? 'Unit' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                                            <h5 class="text-muted">Belum Ada Data Transaksi</h5>
                                                            <p class="text-muted">Transaksi akan muncul di sini setelah
                                                                ditambahkan</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Enhanced Footer -->
                            @if ($datas->count() > 0)
                                <div class="card-footer bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Menampilkan {{ $datas->count() }} transaksi
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

    <!-- Custom CSS -->
    <style>
        .bg-gradient-purple {
            background: linear-gradient(87deg, #8965e0 0, #bc65e0 100%) !important;
        }

        .table-row-hover:hover {
            background-color: #f8f9fa !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .badge {
            font-size: 0.85em;
        }

        .empty-state {
            padding: 2rem;
        }

        .text-gradient {
            font-size: 1.8rem;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .font-weight-medium {
            font-weight: 500;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .text-gradient {
                font-size: 1.4rem;
            }

            .card-body .row.mb-3>div {
                margin-bottom: 0.5rem;
            }

            .table-responsive table td {
                white-space: nowrap;
            }
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        $(document).ready(function() {
            // Initialize DataTable with enhanced features
            let table = $('#tabel_home').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "paging": true,
                "pageLength": 10,
                "dom": 'rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                "language": {
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang cocok"
                }
            });

            // Custom search functionality
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Filter by jenis sampah
            $('#filterJenis').on('change', function() {
                table.column(2).search(this.value).draw();
            });

            // Filter by tanggal
            $('#filterTanggal').on('change', function() {
                let selectedDate = this.value;
                if (selectedDate) {
                    let formattedDate = new Date(selectedDate).toLocaleDateString('id-ID');
                    table.column(0).search(formattedDate).draw();
                } else {
                    table.column(0).search('').draw();
                }
            });

            // Add loading animation
            $('.card').hide().fadeIn(500);
        });

        // Utility functions
        function refreshTable() {
            location.reload();
        }

        function clearFilters() {
            $('#searchInput').val('');
            $('#filterJenis').val('');
            $('#filterTanggal').val('');
            $('#tabel_home').DataTable().search('').columns().search('').draw();
        }

        // Add smooth scroll for better UX
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.content-header').addClass('sticky-header');
            } else {
                $('.content-header').removeClass('sticky-header');
            }
        });
    </script>
@endsection
