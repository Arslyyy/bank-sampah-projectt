@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0 text-danger"><i class="fas fa-file-invoice-dollar"></i> Daftar Transaksi Pengeluaran</h1>
      <a href="{{ route('pengeluaran.create') }}" class="btn btn-danger btn-lg shadow-sm">
        <i class="fas fa-plus"></i> Tambah Pengeluaran
      </a>
    </div>
  </div>

  <!-- Filter Form -->
  <section class="content">
    <div class="container-fluid mb-3">
        <form method="GET" action="{{ route('pengeluaran.index') }}" class="form-inline mb-3">
        {{-- 🔍 Cari ID Transaksi --}}
        <label for="id_transaksi" class="mr-2 font-weight-bold text-danger">ID Transaksi:</label>
        <input type="text" name="id_transaksi" id="id_transaksi"
              value="{{ request('id_transaksi') }}"
              class="form-control mr-3"
              placeholder="Cari ID Transaksi">

        <button type="submit" class="btn btn-danger mr-2">Filter</button>
        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded shadow-sm" role="alert">
          <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-danger text-white d-flex align-items-center">
          <h3 class="card-title m-0"><i class="fas fa-list mr-2"></i> Data Pengeluaran</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap mb-0">
            <thead class="bg-light text-uppercase small text-secondary border-bottom">
              <tr>
                <th style="width: 60px;">No</th>
                <th style="width: 100px;">
                  <i class="fas fa-receipt text-primary mr-1"></i> Id Transaksi
                </th>
                <th style="width: 140px;">
                  <i class="fas fa-calendar-alt text-success mr-1"></i> Tanggal
                </th>
                <th>
                  <i class="fas fa-user text-info mr-1"></i> Nasabah
                </th>
                <th>
                  <i class="fas fa-recycle text-success mr-1"></i> Jenis Sampah
                </th>
                <th class="text-right" style="width: 100px;">
                  <i class="fas fa-weight-hanging text-primary mr-1"></i> Berat Sampah
                </th>
                <th class="text-right" style="width: 140px;">
                  <i class="fas fa-coins text-warning mr-1"></i> Total
                </th>
                <th class="text-center" style="width: 110px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $val)
                <tr>
                  <td class="align-middle font-weight-bold">
                    {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}
                  </td>
                  <td class="align-middle font-monospace">
                    <i class="fas fa-receipt text-primary mr-1"></i> {{ $val->id_transaksi }}
                  </td>
                  <td class="align-middle font-monospace">
                    <i class="fas fa-calendar-alt text-success mr-1"></i>
                    {{ \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y') }}
                  </td>
                  <td class="align-middle text-truncate" style="max-width: 150px;">
                    <i class="fas fa-user text-info mr-1"></i> {{ $val->nasabah->nama ?? '-' }}
                  </td>
                  <td class="align-middle text-truncate" style="max-width: 150px;">
                    <i class="fas fa-recycle text-success mr-1"></i> {{ $val->jenisSampah->type_sampah ?? '-' }}
                  </td>
                  <td class="align-middle text-right font-weight-bold text-danger">
                    <i class="fas fa-weight-hanging text-primary mr-1"></i> {{ $val->jumlah_berat ?? 0 }}
                  </td>
                  <td class="align-middle text-right font-weight-bold text-danger">
                    <i class="fas fa-coins text-warning mr-1"></i>
                    {{ $val->jumlah !== null ? 'Rp ' . number_format($val->jumlah, 0, ',', '.') : '-' }}
                  </td>
                  <td class="align-middle text-center">
                    <a href="{{ route('pengeluaran.edit', $val->id) }}" class="btn btn-sm btn-warning shadow-sm" title="Edit Data">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button type="button"
                            class="btn btn-sm btn-danger shadow-sm btn-delete"
                            data-id="{{ $val->id }}"
                            data-text="Pengeluaran {{ $val->nasabah->nama ?? '' }} - {{ $val->uraian ?? '' }}">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center text-muted py-5 font-italic">
                    <i class="fas fa-info-circle"></i> Belum ada data pengeluaran
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if(method_exists($data, 'links'))
          <div class="card-footer clearfix d-flex justify-content-end">
            {{ $data->links() }}
          </div>
        @endif
      </div>

    </div>
  </section>
</div>

{{-- Modal Konfirmasi Hapus --}}
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
                    <button type="submit" class="btn btn-danger rounded-pill"><i
                            class="fas fa-trash mr-1"></i>Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete').forEach(function (button) {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');
            let text = this.getAttribute('data-text');
            document.getElementById('deleteText').textContent = text;
            document.getElementById('deleteForm').setAttribute('action', '/admin/transaksi/pengeluaran/delete/' + id);
            $('#deleteModal').modal('show');
        });
    });
});
</script>
@endpush

<style>
  .table-hover tbody tr:hover {
    background-color: #f9e9e9;
  }
  .font-monospace {
    font-family: 'Courier New', Courier, monospace;
  }
  .text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .btn-warning, .btn-danger {
    transition: transform 0.15s ease-in-out;
  }
  .btn-warning:hover, .btn-danger:hover {
    transform: scale(1.1);
  }
</style>
@endsection
