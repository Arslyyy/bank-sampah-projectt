@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0 text-danger"><i class="fas fa-file-invoice-dollar"></i> Daftar Transaksi Pengeluaran</h1>
      <div>
        <a href="{{ route('pengeluaran.create') }}" class="btn btn-danger btn-lg shadow-sm">
          <i class="fas fa-plus"></i> Tambah Pengeluaran
        </a>

        <!-- Button Nota -->
        <button type="button" class="btn btn-info btn-lg shadow-sm" data-toggle="modal" data-target="#notaModal">
          <i class="fas fa-file-alt"></i> Nota
        </button>
      </div>
    </div>
  </div>

  <!-- Filter Form -->
  <section class="content">
    <div class="container-fluid mb-3">
      <form method="GET" action="{{ route('pengeluaran.index') }}" class="form-inline align-items-center flex-wrap">

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

        <!-- Filter Nama Nasabah -->
        <label for="nasabah" class="mr-2 font-weight-bold text-danger">Nasabah:</label>
        <input type="text" name="nasabah" id="nasabah"
          value="{{ request('nasabah') }}"
          class="form-control mr-3 mb-2"
          placeholder="Cari Nama Nasabah">

        <!-- Filter Jenis Sampah -->
        <label for="jenis_sampah" class="mr-2 font-weight-bold text-danger">Jenis Sampah:</label>
        <input type="text" name="jenis_sampah" id="jenis_sampah"
          value="{{ request('jenis_sampah') }}"
          class="form-control mr-3 mb-2"
          placeholder="Cari Jenis Sampah">

        <button type="submit" class="btn btn-danger mr-2 mb-2">Filter</button>
        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary mb-2">Reset</a>
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

{{-- Modal Nota --}}
<div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="notaModalLabel"><i class="fas fa-file-alt mr-2"></i> Tampilkan Nota Pengeluaran</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="notaForm">
        <div class="modal-body">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="nasabah_id">Nama Nasabah</label>
              <select name="nasabah_id" id="nasabah_id" class="form-control" required>
                <option value="">-- Pilih Nasabah --</option>
                @foreach(\App\Models\User::where('role', 'nasabah')->get() as $user)
                <option value="{{ $user->nasabah_id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
          </div>

          <!-- Area Nota -->
          <div id="notaResult" class="mt-3" style="max-height:400px; overflow:auto;">
            <!-- Hasil nota akan muncul di sini -->
          </div>
        </div>

        <div class="modal-footer justify-content-center border-0">
          <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-info rounded-pill"><i class="fas fa-search mr-1"></i> Tampilkan Nota</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<!-- Ganti dengan library yang diperlukan untuk PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

  // NOTA - dengan download PDF
  document.getElementById('notaForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let nasabahId = document.getElementById('nasabah_id').value;
    let tanggal = document.getElementById('tanggal').value;
    let token = document.querySelector('input[name="_token"]').value;

    fetch("{{ route('nota.show') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
          nasabah_id: nasabahId,
          tanggal: tanggal
        })
      })
      .then(res => res.json())
      .then(data => {
        let html = '';
        if (data.length > 0) {
          html += `<div id="notaContent" class="p-3 border rounded shadow-sm" style="background:#fff;">
                    <h4 class="text-center mb-3">Nota Pengeluaran</h4>
                    <p><strong>Nasabah:</strong> ${document.getElementById('nasabah_id').selectedOptions[0].text}</p>
                    <p><strong>Tanggal:</strong> ${tanggal}</p>
                    <table class="table table-bordered table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Transaksi</th>
                                <th>Jenis Sampah</th>
                                <th>Berat (kg)</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>`;
          let totalJumlah = 0;
          data.forEach((row, index) => {
            totalJumlah += Number(row.jumlah) || 0;
            html += `<tr>
                        <td>${index+1}</td>
                        <td>${row.id_transaksi}</td>
                        <td>${row.jenis_sampah?.type_sampah ?? '-'}</td>
                        <td>${row.jumlah_berat}</td>
                        <td>${row.jumlah ? 'Rp ' + Number(row.jumlah).toLocaleString('id-ID') : '-'}</td>
                     </tr>`;
          });
          html += `</tbody></table>
                 <h5 class="text-right mt-2">Total: Rp ${totalJumlah.toLocaleString('id-ID')}</h5>
                 <p class="text-center text-muted small mt-3">Terima kasih atas transaksi Anda!</p>
                 <button id="downloadNota" class="btn btn-success btn-sm mt-2" 
                    data-nasabah="${nasabahId}" data-tanggal="${tanggal}">
                    <i class="fas fa-download"></i> Unduh Nota (PDF)
                 </button>
                 </div>`;
        } else {
          html = '<p class="text-center text-muted">Tidak ada transaksi ditemukan untuk nasabah dan tanggal tersebut.</p>';
        }
        document.getElementById('notaResult').innerHTML = html;

        // Tambahkan event listener untuk download PDF
        document.getElementById('downloadNota')?.addEventListener('click', function() {
          const nasabahId = this.getAttribute('data-nasabah');
          const tanggal = this.getAttribute('data-tanggal');
          const nasabahName = document.getElementById('nasabah_id').selectedOptions[0].text;
          
          // Sembunyikan tombol sementara
          this.style.display = 'none';
          
          // Gunakan html2canvas untuk menangkap konten sebagai gambar
          html2canvas(document.getElementById('notaContent'), {
            scale: 2,
            useCORS: true,
            logging: false
          }).then(canvas => {
            // Kembalikan tombol
            this.style.display = 'inline-block';
            
            // Buat PDF
            const imgData = canvas.toDataURL('image/jpeg', 1.0);
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');
            
            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();
            
            // Hitung dimensi gambar untuk muat di halaman PDF
            const imgWidth = pageWidth - 20; // Margin 10mm di kiri dan kanan
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            
            // Tambahkan gambar ke PDF
            doc.addImage(imgData, 'JPEG', 10, 10, imgWidth, imgHeight);
            
            // Simpan PDF
            doc.save(`nota_${nasabahName}_${tanggal}.pdf`);
          });
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