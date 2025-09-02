@extends('adminlte.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <i class="fas fa-weight-hanging text-primary mr-2"></i>
                            List Satuan
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none"><i
                                        class="fas fa-home"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">List Satuan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if ($datas->total() > 0)
                            <div class="row mb-3">
                                <div class="col-lg-4 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            {{-- DIUBAH: Gunakan total() untuk jumlah keseluruhan --}}
                                            <h3>{{ $datas->total() }}</h3>
                                            <p>Total Satuan</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-balance-scale"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card shadow-lg">
                            <div class="card-header bg-gradient-primary">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h3 class="card-title text-white mb-0">
                                            <i class="fas fa-list-alt mr-2"></i>
                                            Data Satuan Bank Sampah
                                        </h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end">
                                            <a href="/admin/bank/satuan/create" class="btn btn-light btn-sm shadow-sm">
                                                <i class="fas fa-plus mr-1"></i>
                                                Tambah Data Satuan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="searchInput"
                                                placeholder="Cari satuan...">
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="semua_tabel" class="table table-bordered table-striped table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="10%" class="text-center">
                                                    <i class="fas fa-hashtag mr-1"></i>
                                                    No
                                                </th>
                                                <th width="70%">
                                                    <i class="fas fa-weight-hanging mr-1"></i>
                                                    Nama Satuan
                                                </th>
                                                <th width="20%" class="text-center">
                                                    <i class="fas fa-cogs mr-1"></i>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($datas as $index => $val)
                                                <tr class="align-middle">
                                                    {{-- DIUBAH: Penomoran yang benar untuk pagination --}}
                                                    <td class="text-center font-weight-bold">
                                                        {{ $datas->firstItem() + $index }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-3">
                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                                    style="width: 35px; height: 35px;">
                                                                    <i class="fas fa-balance-scale text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <strong class="text-dark">{{ $val->satuan }}</strong>
                                                                <br>
                                                                <small class="text-muted">Satuan unit pengukuran</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ url('admin/bank/satuan/edit/' . $val->id) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                title="Edit Data">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete({{ $val->id }})"
                                                                data-toggle="tooltip" title="Hapus Data">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-inbox text-muted" style="font-size: 4rem;"></i>
                                                            <h5 class="text-muted mt-3">Belum Ada Data Satuan</h5>
                                                            <p class="text-muted">Silakan tambahkan data satuan terlebih
                                                                dahulu</p>
                                                            <a href="/adminn/bank/satuan/create" class="btn btn-primary">
                                                                <i class="fas fa-plus mr-1"></i>
                                                                Tambah Data Pertama
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- DITAMBAHKAN: Link untuk navigasi halaman --}}
                                <div class="mt-3 d-flex justify-content-center">
                                    {{ $datas->links() }}
                                </div>
                            </div>
                            @if ($datas->total() > 0)
                                <div class="card-footer bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                Menampilkan {{ $datas->count() }} dari {{ $datas->total() }} data satuan.
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Terakhir diperbarui: {{ now()->translatedFormat('d F Y, H:i') }}
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Apakah Anda yakin?</h5>
                    <p class="text-muted">Data satuan yang dihapus tidak dapat dikembalikan lagi.</p>
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
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
        let url = "{{ url('admin/bank/satuan') }}/" + id;
        $('#deleteForm').attr('action', url);
        $('#deleteModal').modal('show');
        }

        $(document).ready(function() {
            var table = $('#semua_tabel').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "info": false,
                "paging": false, // Paging dimatikan karena kita pakai paging dari Laravel
                "dom": 'lrtip',
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia"
                }
            });

            $('[data-toggle="tooltip"]').tooltip();

            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        });
    </script>
    <style>
        .small-box {
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .small-box:hover {
            transform: translateY(-5px);
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .table th {
            border-top: none;
            font-weight: 600;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .empty-state {
            padding: 2rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .input-group-text {
            border: 1px solid #ced4da;
        }
    </style>
@endpush
