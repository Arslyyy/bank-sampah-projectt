@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0 text-success"><i class="fas fa-cash-register"></i> Daftar Transaksi Pemasukan</h1>
      <a href="{{ route('pemasukkan.create') }}" class="btn btn-success btn-lg shadow-sm">
        <i class="fas fa-plus"></i> Tambah Transaksi
      </a>
    </div>
  </div>

  <!-- Filter Form -->
<section class="content">
  <div class="container-fluid mb-3">
    <form method="GET" action="{{ route('pemasukkan.index') }}" class="form-inline align-items-center">
      <!-- Filter Bulan -->
      <label for="bulan" class="mr-2 font-weight-bold text-success">Bulan:</label>
      <select name="bulan" id="bulan" class="form-control mr-3">
        <option value="">-- Semua Bulan --</option>
        @foreach(range(1, 12) as $m)
          <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
          </option>
        @endforeach
      </select>

      <!-- Filter Tahun -->
      <label for="tahun" class="mr-2 font-weight-bold text-success">Tahun:</label>
      <select name="tahun" id="tahun" class="form-control mr-3">
        <option value="">-- Semua Tahun --</option>
        @for($y = date('Y'); $y >= 2020; $y--)
          <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
            {{ $y }}
          </option>
        @endfor
      </select>

      <button type="submit" class="btn btn-success mr-2">Filter</button>
      <a href="{{ route('pemasukkan.index') }}" class="btn btn-secondary">Reset</a>
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
        <div class="card-header bg-success text-white d-flex align-items-center">
          <h3 class="card-title m-0"><i class="fas fa-list mr-2"></i> Data Pemasukan</h3>
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
        <i class="fas fa-file-alt text-info mr-1"></i> Uraian / Keterangan
      </th>
      <th class="text-right" style="width: 140px;">
        <i class="fas fa-coins text-warning mr-1"></i> Jumlah
      </th>
      <th style="width: 140px;">
        <i class="fas fa-file-image text-danger mr-1"></i> Upload Nota
      </th>
      <th class="text-center" style="width: 110px;">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($data as $item)
      <tr>
        <td class="align-middle font-weight-bold">
          {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}
        </td>
        <td class="align-middle font-monospace">
          <i class="fas fa-receipt text-primary mr-1"></i> {{ $item->id_transaksi }}
        </td>
        <td class="align-middle font-monospace">
          <i class="fas fa-calendar-alt text-success mr-1"></i> 
          {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y') }}
        </td>
        <td class="align-middle text-truncate" style="max-width: 200px;">
          <i class="fas fa-file-alt text-info mr-1"></i> {{ $item->uraian ?? '-' }}
        </td>
        <td class="align-middle text-right font-weight-bold text-success">
          <i class="fas fa-coins text-warning mr-1"></i> 
          Rp {{ number_format($item->jumlah, 0, ',', '.') }}
        </td>
        <td class="align-middle">
          @if($item->image)
            <a href="{{ asset('storage/'.$item->image) }}" target="_blank" class="btn btn-sm btn-outline-info">
              <i class="fas fa-eye mr-1"></i> Lihat Gambar
            </a>
          @else
            <span class="text-muted"><i class="fas fa-times-circle mr-1"></i> -</span>
          @endif
        </td>
        <td class="align-middle text-center">
          <a href="{{ route('pemasukkan.edit', $item->id) }}" class="btn btn-sm btn-warning shadow-sm" title="Edit Data">
            <i class="fas fa-edit"></i>
          </a>
          <button type="button"
                  class="btn btn-sm btn-danger shadow-sm btn-delete"
                  data-id="{{ $item->id }}"
                  data-uraian="{{ $item->uraian }}"
                  title="Hapus Data">
            <i class="fas fa-trash"></i>
          </button>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center text-muted py-5 font-italic">
          <i class="fas fa-info-circle"></i> Belum ada data pemasukan
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
            let uraian = this.getAttribute('data-uraian') || 'data ini';

            // Ambil URL dari route Laravel dan ganti :id dengan ID asli
            let actionUrl = "{{ route('pemasukkan.destroy', ':id') }}";
            actionUrl = actionUrl.replace(':id', id);

            document.getElementById('deleteForm').setAttribute('action', actionUrl);
            document.getElementById('deleteText').textContent = 'Transaksi: ' + uraian;
            $('#deleteModal').modal('show');
        });
    });
});
</script>
@endpush


<style>
  .table-hover tbody tr:hover {
    background-color: #eafaf1;
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
