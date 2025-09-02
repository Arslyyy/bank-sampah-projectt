@extends('adminlte.layouts.app')

@section('title', 'Jenis Sampah')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-gradient"
                            style="background: linear-gradient(45deg, #6f42c1, #e83e8c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold;">
                            <i class="fas fa-layer-group mr-2"></i>Jenis Sampah
                        </h1>
                        <p class="text-muted mb-0">Kelola kategori dan jenis sampah</p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-light rounded px-3 py-2">
                            <li class="breadcrumb-item"><a href="#" class="text-purple"><i class="fas fa-home"></i>
                                    Dashboard</a></li>
                            <li class="breadcrumb-item active text-secondary">List Jenis Sampah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-purple shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Total Jenis</h5>
                                        <h3 class="mb-0">{{ $datas->count() }}</h3>
                                    </div>
                                    <div class="ml-3"><i class="fas fa-layer-group fa-2x opacity-75"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-success shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Organik</h5>
                                        <h3 class="mb-0">
                                            {{ $datas->filter(function ($item) {return stripos($item->type_sampah, 'organik') !== false;})->count() }}
                                        </h3>
                                    </div>
                                    <div class="ml-3"><i class="fas fa-seedling fa-2x opacity-75"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-warning shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Anorganik</h5>
                                        <h3 class="mb-0">
                                            {{ $datas->filter(function ($item) {return stripos($item->type_sampah, 'anorganik') !== false || stripos($item->type_sampah, 'plastik') !== false;})->count() }}
                                        </h3>
                                    </div>
                                    <div class="ml-3"><i class="fas fa-recycle fa-2x opacity-75"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card bg-gradient-info shadow-lg border-0">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Lainnya</h5>
                                        <h3 class="mb-0">
                                            {{ $datas->filter(function ($item) {return !in_array(strtolower(explode(' ', $item->type_sampah)[0]), ['organik', 'anorganik', 'plastik']);})->count() }}
                                        </h3>
                                    </div>
                                    <div class="ml-3"><i class="fas fa-boxes fa-2x opacity-75"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-header bg-gradient-purple text-white" style="border-radius: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-1"><i class="fas fa-list mr-2"></i>Data Jenis Sampah</h3>
                                    </div>
                                    <div class="card-tools">
                                        <a href="/admin/bank/jenis/create" class="text-decoration-none">
                                            <button class="btn btn-light btn-sm rounded-pill shadow-sm" type="button"><i
                                                    class="fas fa-plus mr-1"></i> Tambah Data</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body bg-light pb-2">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-search text-muted"></i></span>
                                            <input type="text" class="form-control border-left-0" id="searchInput"
                                                placeholder="Cari jenis sampah...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control custom-select" id="filterCategory">
                                            <option value="">Semua Kategori</option>
                                            <option value="organik">Organik</option>
                                            <option value="anorganik">Anorganik</option>
                                            <option value="plastik">Plastik</option>
                                            <option value="kertas">Kertas</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-outline-secondary btn-block" onclick="clearFilters()"><i
                                                class="fas fa-eraser"></i> Reset</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table id="semua_tabel" class="table table-hover table-borderless">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm text-center"><i
                                                        class="fas fa-hashtag text-purple mr-1"></i>No</th>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm"><i
                                                        class="fas fa-layer-group text-success mr-1"></i>Jenis / Type
                                                    Sampah</th>
                                                <th class="border-0 font-weight-bold text-uppercase text-sm text-center"><i
                                                        class="fas fa-cogs text-info mr-1"></i>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($datas as $index => $val)
                                                <tr class="table-row-hover">
                                                    <td class="py-3 text-center align-middle">
                                                        <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                                            style="width: 35px; height: 35px;">
                                                            <strong>{{ $index + 1 }}</strong>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 align-middle">
                                                        <div class="d-flex align-items-center">
                                                            @php
                                                                $type = strtolower($val->type_sampah);
                                                                $icon = 'fas fa-leaf';
                                                                $bgColor = 'success';
                                                                if (stripos($type, 'plastik') !== false) {
                                                                    $icon = 'fas fa-wine-bottle';
                                                                    $bgColor = 'warning';
                                                                } elseif (
                                                                    stripos($type, 'logam') !== false ||
                                                                    stripos($type, 'besi') !== false
                                                                ) {
                                                                    $icon = 'fas fa-tools';
                                                                    $bgColor = 'secondary';
                                                                } elseif (
                                                                    stripos($type, 'kertas') !== false ||
                                                                    stripos($type, 'karton') !== false
                                                                ) {
                                                                    $icon = 'fas fa-file-alt';
                                                                    $bgColor = 'info';
                                                                } elseif (stripos($type, 'kaca') !== false) {
                                                                    $icon = 'fas fa-glass-martini';
                                                                    $bgColor = 'primary';
                                                                }
                                                            @endphp
                                                            <div class="bg-{{ $bgColor }} text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                                style="width: 50px; height: 50px; font-size: 1.2rem;">
                                                                <i class="{{ $icon }}"></i>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold text-lg mb-1">
                                                                    {{ $val->type_sampah }}</div>
                                                                <div class="d-flex flex-wrap">
                                                                    @if (stripos($type, 'organik') !== false)
                                                                        <span
                                                                            class="badge badge-success badge-sm mr-1 mb-1"><i
                                                                                class="fas fa-seedling mr-1"></i>Organik</span>
                                                                    @endif
                                                                    @if (stripos($type, 'anorganik') !== false)
                                                                        <span
                                                                            class="badge badge-warning badge-sm mr-1 mb-1"><i
                                                                                class="fas fa-recycle mr-1"></i>Anorganik</span>
                                                                    @endif
                                                                    @if (stripos($type, 'plastik') !== false)
                                                                        <span
                                                                            class="badge badge-info badge-sm mr-1 mb-1"><i
                                                                                class="fas fa-wine-bottle mr-1"></i>Plastik</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 text-center align-middle">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ url('admin/bank/jenis/edit/' . $val->id) }}"
                                                                class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                                                title="Edit Data"><i class="fas fa-edit mr-1"></i>Edit</a>
                                                            <button
                                                                class="btn btn-outline-danger btn-sm rounded-pill px-3 ml-1"
                                                                onclick="confirmDelete({{ $val->id }}, '{{ $val->type_sampah }}')"
                                                                title="Hapus Data"><i
                                                                    class="fas fa-trash mr-1"></i>Hapus</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-layer-group fa-4x text-muted mb-3"></i>
                                                            <h5 class="text-muted">Belum Ada Data Jenis Sampah</h5>
                                                            <p class="text-muted mb-3">Tambahkan jenis sampah untuk memulai
                                                            </p>
                                                            <a href="/bank/jenis/create"
                                                                class="btn btn-purple rounded-pill"><i
                                                                    class="fas fa-plus mr-1"></i>Tambah Jenis Pertama</a>
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
                                        <div class="col-md-6"><small class="text-muted"><i
                                                    class="fas fa-info-circle mr-1"></i>Total {{ $datas->count() }} jenis
                                                sampah terdaftar</small></div>
                                        <div class="col-md-6 text-right"><small class="text-muted"><i
                                                    class="fas fa-clock mr-1"></i>Terakhir diperbarui:
                                                {{ now()->format('d/m/Y H:i') }}</small></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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
                        <button type="submit" class="btn btn-danger rounded-pill" id="confirmDeleteBtn"><i
                                class="fas fa-trash mr-1"></i>Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient-purple {
            background: linear-gradient(87deg, #6f42c1 0, #e83e8c 100%) !important;
        }

        .bg-purple {
            background-color: #6f42c1 !important;
        }

        .btn-purple {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: white;
        }

        .btn-purple:hover {
            background-color: #5a359a;
            border-color: #5a359a;
            color: white;
        }

        .text-purple {
            color: #6f42c1 !important;
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

        .badge-sm {
            font-size: 0.7em;
            padding: 0.25em 0.5em;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // --- FUNGSI FILTER KUSTOM DATATABLES ---
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                if (settings.nTable.id !== 'semua_tabel') return true;
                let category = $('#filterCategory').val().toLowerCase();
                let rowData = data[1].toLowerCase(); // data[1] adalah kolom "Jenis / Type Sampah"
                if (category === "" || rowData.includes(category)) return true;
                return false;
            }
        );

        // --- FUNGSI GLOBAL ---
        function clearFilters() {
            $('#searchInput').val('');
            $('#filterCategory').val('').trigger('change');
        }

        function confirmDelete(id, nama) {
            const form = document.getElementById('deleteForm');
            form.action = `admin/bank/jenis/delete/${id}`; // Sesuaikan dengan URL hapus Anda
            $('#deleteText').text(`Jenis sampah "${nama}" akan dihapus dari sistem.`);
            $('#deleteModal').modal('show');
        }

        // --- KODE JQUERY SAAT HALAMAN SIAP ---
        $(document).ready(function() {
            let table = $('#semua_tabel').DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                info: false,
                paging: true,
                pageLength: 10,
                dom: 'rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                order: [
                    [1, "asc"]
                ],
                columnDefs: [{
                    "targets": [0, 2],
                    "orderable": false
                }],
                language: {
                    paginate: {
                        next: "→",
                        previous: "←"
                    },
                    emptyTable: "Tidak ada data yang tersedia",
                    zeroRecords: "Tidak ada data yang cocok",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                }
            });

            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('#filterCategory').on('change', function() {
                table.draw();
            });

            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let actionUrl = form.attr('action');
                let submitButton = $('#confirmDeleteBtn');

                submitButton.html('<i class="fas fa-spinner fa-spin mr-1"></i> Menghapus...').prop(
                    'disabled', true);

                $.ajax({
                    type: 'POST',
                    url: actionUrl,
                    data: form.serialize(),
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        toastr.success(response.success);
                        let rowToRemove = $('button[onclick*="confirmDelete(' + actionUrl.split(
                            '/').pop() + ',"]').closest('tr');
                        table.row(rowToRemove).remove().draw();
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        submitButton.html('<i class="fas fa-trash mr-1"></i> Ya, Hapus').prop(
                            'disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
