<!-- Content Wrapper. Contains page content -->
@extends('adminlte.layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <i class="fas fa-users text-primary mr-2"></i>
                            Manajemen Nasabah
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none"><i
                                        class="fas fa-home"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">List Nasabah</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Info Boxes -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ count($datas) }}</h3>
                                <p>Total Nasabah</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ collect($datas)->where('status', 'aktif')->count() ?? count($datas) }}</h3>
                                <p>Nasabah Aktif</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ collect($datas)->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() ?? 5 }}
                                </h3>
                                <p>Pendaftar Bulan Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ collect($datas)->where('status', 'nonaktif')->count() ?? 0 }}</h3>
                                <p>Nasabah Non-Aktif</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-times"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">

                        <div class="card shadow-lg">
                            <div class="card-header bg-gradient-primary">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h3 class="card-title text-white mb-0">
                                            <i class="fas fa-address-book mr-2"></i>
                                            Data Nasabah Bank Sampah
                                        </h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end">
                                            <a href="/admin/manajemen/nasabah/create" class="btn btn-light btn-sm shadow-sm mr-2">
                                                <i class="fas fa-user-plus mr-1"></i>
                                                Tambah Nasabah Baru
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-cog mr-1"></i>
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#" onclick="exportData('excel')">
                                                        <i class="fas fa-file-excel text-success mr-2"></i>
                                                        Export Excel
                                                    </a>
                                                    <a class="dropdown-item" href="#" onclick="exportData('pdf')">
                                                        <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                        Export PDF
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" onclick="printData()">
                                                        <i class="fas fa-print text-info mr-2"></i>
                                                        Cetak Data
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <!-- Search and Filter Section -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="searchInput"
                                                placeholder="Cari nama atau alamat nasabah...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" id="statusFilter">
                                            <option value="">Semua Status</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif">Non-Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" id="sortBy">
                                            <option value="nama">Urutkan: Nama A-Z</option>
                                            <option value="nama_desc">Urutkan: Nama Z-A</option>
                                            <option value="alamat">Urutkan: Alamat A-Z</option>
                                            <option value="terbaru">Urutkan: Terbaru</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-outline-secondary btn-block" onclick="resetFilters()">
                                            <i class="fas fa-undo mr-1"></i>
                                            Reset
                                        </button>
                                    </div>
                                </div>

                                <!-- Data Table -->
                                <div class="table-responsive">
                                    <table id="semua_tabel" class="table table-bordered table-striped table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="8%" class="text-center">
                                                    <i class="fas fa-hashtag mr-1"></i>
                                                    No
                                                </th>
                                                <th width="15%" class="text-center">
                                                    <i class="fas fa-user-circle mr-1"></i>
                                                    Foto
                                                </th>
                                                <th width="25%">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Nama Nasabah
                                                </th>
                                                <th width="30%">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    Alamat
                                                </th>
                                                <th width="12%" class="text-center">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Status
                                                </th>
                                                <th width="10%" class="text-center">
                                                    <i class="fas fa-cogs mr-1"></i>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($datas as $index => $val)
                                                <tr class="align-middle nasabah-row"
                                                    data-status="{{ $val->status ?? 'aktif' }}">
                                                    <td class="text-center font-weight-bold">{{ $index + 1 }}</td>
                                                    <td class="text-center">
                                                        <div class="user-avatar">
                                                            @if (isset($val->foto) && $val->foto)
                                                                <img src="{{ asset('storage/' . $val->foto) }}"
                                                                    alt="Foto {{ $val->nama }}"
                                                                    class="img-circle elevation-2" width="50"
                                                                    height="50">
                                                            @else
                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                                                    style="width: 50px; height: 50px;">
                                                                    <i class="fas fa-user text-white fa-lg"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="user-info">
                                                            <strong class="text-dark d-block">{{ $val->nama }}</strong>
                                                            @if (isset($val->phone))
                                                                <small class="text-muted">
                                                                    <i class="fas fa-phone mr-1"></i>
                                                                    {{ $val->phone }}
                                                                </small>
                                                            @endif
                                                            @if (isset($val->email))
                                                                <br>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-envelope mr-1"></i>
                                                                    {{ $val->email }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="address-info">
                                                            <span class="text-dark">{{ $val->alamat }}</span>
                                                            @if (isset($val->kecamatan))
                                                                <br>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-map mr-1"></i>
                                                                    {{ $val->kecamatan }}, {{ $val->kota ?? '' }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $status = $val->status ?? 'aktif';
                                                            $badgeClass =
                                                                $status == 'aktif' ? 'badge-success' : 'badge-danger';
                                                            $icon =
                                                                $status == 'aktif'
                                                                    ? 'fas fa-check-circle'
                                                                    : 'fas fa-times-circle';
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} badge-pill px-3 py-2">
                                                            <i class="{{ $icon }} mr-1"></i>
                                                            {{ ucfirst($status) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ url('/admin/manajemen/nasabah/show/' . $val->id) }}"
                                                                class="btn btn-info btn-sm" data-toggle="tooltip"
                                                                title="Lihat Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ url('/admin/manajemen/nasabah/edit/' . $val->id) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                title="Edit Data">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete({{ $val->id }}, '{{ $val->nama }}')"
                                                                data-toggle="tooltip" title="Hapus Data">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-user-slash text-muted"
                                                                style="font-size: 4rem;"></i>
                                                            <h5 class="text-muted mt-3">Belum Ada Data Nasabah</h5>
                                                            <p class="text-muted mb-4">Silakan tambahkan nasabah pertama
                                                                untuk memulai</p>
                                                            <a href="/admin/manajemen/nasabah/create" class="btn btn-primary">
                                                                <i class="fas fa-user-plus mr-1"></i>
                                                                Tambah Nasabah Pertama
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <!-- Card Footer with Pagination Info -->
                            @if (count($datas) > 0)
                                <div class="card-footer bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Menampilkan <span id="showingCount">{{ count($datas) }}</span> dari
                                                {{ count($datas) }} nasabah
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Terakhir diperbarui: {{ date('d F Y, H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Konfirmasi Hapus Nasabah
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Apakah Anda yakin?</h5>
                    <p class="text-muted">Anda akan menghapus nasabah "<strong id="nasabahName"></strong>"</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Data nasabah yang dihapus tidak dapat dikembalikan lagi!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i>
                            Ya, Hapus Nasabah
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Nasabah Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-user mr-2"></i>
                        Detail Nasabah
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#semua_tabel').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false, // We use custom search
                "info": false,
                "paging": true,
                "pageLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    },
                    "emptyTable": "Tidak ada data nasabah"
                }
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Custom search functionality
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                filterTable();
            });

            // Status filter
            $('#statusFilter').on('change', function() {
                filterTable();
            });

            // Sort functionality
            $('#sortBy').on('change', function() {
                sortTable($(this).val());
            });

            function filterTable() {
                var searchValue = $('#searchInput').val().toLowerCase();
                var statusValue = $('#statusFilter').val().toLowerCase();
                var visibleCount = 0;

                $('#semua_tabel tbody tr.nasabah-row').each(function() {
                    var row = $(this);
                    var nama = row.find('td:nth-child(3)').text().toLowerCase();
                    var alamat = row.find('td:nth-child(4)').text().toLowerCase();
                    var status = row.data('status').toLowerCase();

                    var matchSearch = nama.includes(searchValue) || alamat.includes(searchValue);
                    var matchStatus = statusValue === '' || status === statusValue;

                    if (matchSearch && matchStatus) {
                        row.show();
                        visibleCount++;
                    } else {
                        row.hide();
                    }
                });

                $('#showingCount').text(visibleCount);

                // Show/hide empty state
                if (visibleCount === 0 && ($('#searchInput').val() !== '' || $('#statusFilter').val() !== '')) {
                    showNoResults();
                } else {
                    hideNoResults();
                }
            }

            function sortTable(sortBy) {
                var tbody = $('#semua_tabel tbody');
                var rows = tbody.find('tr.nasabah-row').toArray();

                rows.sort(function(a, b) {
                    var aVal, bVal;

                    switch (sortBy) {
                        case 'nama':
                            aVal = $(a).find('td:nth-child(3)').text().trim();
                            bVal = $(b).find('td:nth-child(3)').text().trim();
                            return aVal.localeCompare(bVal);
                        case 'nama_desc':
                            aVal = $(a).find('td:nth-child(3)').text().trim();
                            bVal = $(b).find('td:nth-child(3)').text().trim();
                            return bVal.localeCompare(aVal);
                        case 'alamat':
                            aVal = $(a).find('td:nth-child(4)').text().trim();
                            bVal = $(b).find('td:nth-child(4)').text().trim();
                            return aVal.localeCompare(bVal);
                        case 'terbaru':
                            // Assuming newest first by default order
                            return 0;
                        default:
                            return 0;
                    }
                });

                // Re-number the rows
                $.each(rows, function(index, row) {
                    $(row).find('td:first-child').text(index + 1);
                    tbody.append(row);
                });
            }

            function showNoResults() {
                if ($('#noResultsRow').length === 0) {
                    var noResultsHtml = '<tr id="noResultsRow"><td colspan="6" class="text-center py-4">' +
                        '<i class="fas fa-search text-muted" style="font-size: 2rem;"></i>' +
                        '<h6 class="text-muted mt-2">Tidak ada hasil yang ditemukan</h6>' +
                        '<small class="text-muted">Coba ubah kata kunci atau filter pencarian</small>' +
                        '</td></tr>';
                    $('#semua_tabel tbody').append(noResultsHtml);
                }
            }

            function hideNoResults() {
                $('#noResultsRow').remove();
            }

            function resetFilters() {
                $('#searchInput').val('');
                $('#statusFilter').val('');
                $('#sortBy').val('nama');
                filterTable();
                toastr.info('Filter telah direset');
            }

            // Make resetFilters global
            window.resetFilters = resetFilters;
        });

        // Delete confirmation function
        function confirmDelete(id, nama) {
            $('#deleteForm').attr('action', '/admin/manajemen/nasabah/' + id);
            $('#nasabahName').text(nama);
            $('#deleteModal').modal('show');
        }

        // Export functions
        function exportData(type) {
            if (type === 'excel') {
                toastr.info('Fitur export Excel akan segera tersedia');
            } else if (type === 'pdf') {
                toastr.info('Fitur export PDF akan segera tersedia');
            }
        }

        function printData() {
            window.print();
        }

        // Show success message if data is added/updated/deleted
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>

    <style>
        .small-box {
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .small-box .inner {
            padding: 20px;
        }

        .small-box .icon {
            transition: all 0.3s ease;
        }

        .small-box:hover .icon {
            transform: scale(1.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-group .btn {
            margin: 0 1px;
            border-radius: 6px;
        }

        .empty-state {
            padding: 3rem 2rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        .btn {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .user-avatar img {
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-info strong {
            font-size: 1rem;
            color: #2c3e50;
        }

        .address-info {
            max-width: 300px;
        }

        .badge-pill {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        @media (max-width: 768px) {
            .d-flex.justify-content-end {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                margin: 2px 0;
                border-radius: 8px;
            }

            .small-box .inner h3 {
                font-size: 1.8rem;
            }

            .table-responsive {
                font-size: 0.85rem;
            }
        }

        /* Animation for statistics boxes */
        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .small-box .inner h3 {
            animation: countUp 0.8s ease forwards;
        }

        /* Loading animation */
        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
