@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0 text-danger"><i class="fas fa-briefcase"></i> Daftar Transaksi Operasional</h1>
      <div>
        <a href="{{ route('operasional.create') }}" class="btn btn-danger btn-lg shadow-sm">
          <i class="fas fa-plus"></i> Tambah Operasional
        </a>
      </div>
    </div>
  </div>

  <!-- Filter Form -->
  <section class="content">
    <div class="container-fluid mb-3">
      <form method="GET" action="{{ route('operasional.index') }}" class="form-inline align-items-center flex-wrap">

        <!-- Filter Bulan -->
        <label for="bulan" class="mr-2 font-weight-bold text-danger">Bulan:</label>
        <select name="bulan" id="bulan" class="form-control mr-3 mb-2">
          <option value="">-- Semua Bulan --</option>
          @foreach(range(1,12) as $m)
          <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
          </option>
          @endforeach
        </select>

        <!-- Filter Tahun -->
        <label for="tahun" class="mr-2 font-weight-bold text-danger">Tahun:</label>
        <select name="tahun" id="tahun" class="form-control mr-3 mb-2">
          <option value="">-- Semua Tahun --</option>
          @for($y = date('Y'); $y >= 2020; $y--)
          <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
            {{ $y }}
          </option>
          @endfor
        </select>

        <button type="submit" class="btn btn-danger mr-2 mb-2">Filter</button>
        <a href="{{ route('operasional.index') }}" class="btn btn-secondary mb-2">Reset</a>
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
          <h3 class="card-title m-0"><i class="fas fa-list mr-2"></i> Data Operasional</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap mb-0">
            <thead class="bg-light text-uppercase small text-secondary border-bottom">
              <tr>
                <th style="width: 60px;">No</th>
                <th style="width: 140px;">
                  <i class="fas fa-calendar-alt text-success mr-1"></i> Tanggal
                </th>
                <th style="width: 160px;">
                  <i class="fas fa-tags text-info mr-1"></i> Jenis Operasional
                </th>
                <th class="text-right" style="width: 140px;">
                  <i class="fas fa-coins text-warning mr-1"></i> Jumlah
                </th>
                <th>
                  <i class="fas fa-align-left text-primary mr-1"></i> Uraian
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
                  {{ \Carbon\Carbon::parse($val->tanggal)->format('d/m/Y') }}
                </td>
                <td class="align-middle text-truncate">
                  {{ ucfirst($val->jenis_operasional) }}
                </td>
                <td class="align-middle text-right font-weight-bold text-danger">
                  Rp {{ number_format($val->jumlah, 0, ',', '.') }}
                </td>
                <td class="align-middle text-truncate" style="max-width: 250px;">
                  {{ $val->uraian ?? '-' }}
                </td>
                <td class="align-middle text-center">
                  <a href="{{ route('operasional.edit', $val->id) }}" class="btn btn-sm btn-warning shadow-sm" title="Edit Data">
                    <i class="fas fa-edit"></i>
                  </a>

                  <!-- Tombol trigger modal -->
                  <button type="button" class="btn btn-sm btn-danger shadow-sm" data-toggle="modal" data-target="#deleteModal{{ $val->id }}" title="Hapus Data">
                    <i class="fas fa-trash"></i>
                  </button>

                  <!-- Modal konfirmasi -->
                  <div class="modal fade" id="deleteModal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $val->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                          <h5 class="modal-title" id="deleteModalLabel{{ $val->id }}">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi Hapus
                          </h5>
                          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline:none;">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                          <p class="mb-3">
                            Apakah Anda yakin ingin menghapus data <strong>{{ ucfirst($val->jenis_operasional) }}</strong> 
                            pada tanggal <strong>{{ \Carbon\Carbon::parse($val->tanggal)->format('d/m/Y') }}</strong>?
                          </p>
                          <p class="text-danger small"><i class="fas fa-info-circle"></i> Data yang sudah dihapus tidak bisa dikembalikan.</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                          <form action="{{ route('operasional.destroy', $val->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                              <i class="fas fa-trash mr-1"></i> Ya, Hapus
                            </button>
                          </form>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Batal
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-5 font-italic">
                  <i class="fas fa-info-circle"></i> Belum ada data operasional
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
  .btn-warning,
  .btn-danger {
    transition: transform 0.15s ease-in-out;
  }
  .btn-warning:hover,
  .btn-danger:hover {
    transform: scale(1.1);
  }
</style>
@endsection
