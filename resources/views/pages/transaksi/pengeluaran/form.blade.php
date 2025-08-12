{{-- resources/views/transaksi/pengeluaran/form.blade.php --}}
@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">
            {{ isset($data) ? 'Edit' : 'Create' }} Transaksi Pengeluaran
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pengeluaran.index') }}">Pengeluaran</a></li>
            <li class="breadcrumb-item active">{{ isset($data) ? 'Edit' : 'Create' }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-8">

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form {{ isset($data) ? 'Edit' : 'Create' }} Pengeluaran</h3>
            </div>

            <form action="{{ isset($data) ? route('pengeluaran.update', $data->id) : route('pengeluaran.store') }}" method="POST">
              @csrf
              @if(isset($data))
                @method('PUT')
              @endif

              <div class="card-body">
                
                <!-- Tanggal -->
                <div class="form-group">
                  <label>Tanggal Transaksi</label>
                  <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                    name="tanggal_transaksi"
                    value="{{ old('tanggal_transaksi', $data->tanggal_transaksi ?? '') }}"
                    required>
                  @error('tanggal_transaksi')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <!-- Nasabah -->
                <div class="form-group">
                  <label>Nasabah</label>
                  <select name="master_nasabah_id" class="form-control @error('master_nasabah_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabah as $n)
                      <option value="{{ $n->id }}" {{ old('master_nasabah_id', $data->master_nasabah_id ?? '') == $n->id ? 'selected' : '' }}>
                        {{ $n->nama }}
                      </option>
                    @endforeach
                  </select>
                  @error('master_nasabah_id')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <!-- Jenis Sampah -->
                <div class="form-group">
                  <label>Jenis Sampah</label>
                  <select name="master_jenis_sampah_id" class="form-control" required>
                    <option value="">-- Pilih Jenis Sampah --</option>
                    @foreach($jenisSampah as $js)
                      <option value="{{ $js->id }}" {{ old('master_jenis_sampah_id', $data->master_jenis_sampah_id ?? '') == $js->id ? 'selected' : '' }}>
                        {{ $js->type_sampah }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <!-- Satuan -->
                <div class="form-group">
                  <label>Satuan</label>
                  <select name="master_satuan_id" class="form-control" required>
                    <option value="">-- Pilih Satuan --</option>
                    @foreach($satuan as $s)
                      <option value="{{ $s->id }}" {{ old('master_satuan_id', $data->master_satuan_id ?? '') == $s->id ? 'selected' : '' }}>
                        {{ $s->satuan }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Jumlah --}}
                <div class="form-group mb-3">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" class="form-control" id="jumlah" name="jumlah"
                        value="{{ isset($data) ? number_format($data->jumlah, 0, ',', '.') : old('jumlah') }}"
                        placeholder="Masukkan jumlah" required>
                </div>

                <!-- Uraian -->
                <div class="form-group">
                  <label>Uraian/Keterangan</label>
                  <textarea name="uraian" class="form-control">{{ old('uraian', $data->uraian ?? '') }}</textarea>
                </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                  {{ isset($data) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('pengeluaran.index') }}" class="btn btn-default float-right">Kembali</a>
              </div>
            </form>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>
{{-- Script Format Rupiah --}}
<script>
document.getElementById('jumlah').addEventListener('input', function(e) {
    let angka = e.target.value.replace(/[^0-9]/g, '');
    e.target.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
});
@endsection
