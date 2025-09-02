@extends('adminlte.layouts.app2')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid mb-3">
    </div>
  </section>

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
        <div class="card-body p-0 table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light text-uppercase small text-secondary border-bottom">
              <tr>
                <th style="width: 40px;">No</th>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Jenis Sampah</th>
                <th class="text-right">Uraian</th>
                <th class="text-right">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $val)
                <tr>
                  <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                  <td class="align-middle font-monospace">{{ \Carbon\Carbon::parse($val->tanggal_transaksi)->format('d/m/Y') }}</td>
                  <td class="align-middle">{{ $val->nasabah->nama ?? '-' }}</td>
                  <td class="align-middle">{{ $val->jenisSampah->type_sampah ?? '-' }}</td>
                  <td class="align-middle text-right" style="max-width: 180px;">{{ $val->uraian ?? '-' }}</td>
                  <td class="align-middle text-right font-weight-bold text-danger">
                    {{ $val->jumlah !== null ? 'Rp ' . number_format($val->jumlah, 0, ',', '.') : '-' }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center text-muted py-5 font-italic">
                    <i class="fas fa-info-circle"></i> Data pengeluaran belum tersedia.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if(method_exists($data, 'links'))
          <div class="card-footer d-flex justify-content-end">
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
                    <button type="submit" class="btn btn-danger rounded-pill" id="confirmDeleteBtn"><i
                            class="fas fa-trash mr-1"></i>Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

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

{{-- Script untuk handle delete modal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let text = this.getAttribute('data-text');
            document.getElementById('deleteText').textContent = text;
            document.getElementById('deleteForm').setAttribute('action', '/admin/transaksi/pengeluaran/delete/' + id);
            $('#deleteModal').modal('show');
        });
    });
});
</script>
@endsection
