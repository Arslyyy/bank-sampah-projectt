<!-- Content Wrapper. Contains page content -->
@extends('adminlte.layouts.app')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">
            {{ $data ? 'Edit' : 'Create' }} Transaksi
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/transaksi/data-transaksi">Transaksi</a></li>
            <li class="breadcrumb-item active">{{ $data ? 'Edit' : 'Create' }} Nasabah</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form {{ $data ? 'Edit' : 'Create' }} Nasabah</h3>
            </div>

            <form class="form-horizontal"
                  action="{{ $data 
                    ? url('transaksi/data-transaksi/update', $data->id)
                    : url('transaksi/data-transaksi/store') }}"
                  method="POST" enctype="multipart/form-data">
              @csrf
              @if($data) @method('PUT') @endif

              <div class="card-body">

                {{-- Tanggal Transaksi --}}
                <div class="form-group">
                  <label>Tanggal Transaksi</label>
                  <input type="date" 
                         class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                         name="tanggal_transaksi"
                         value="{{ old('tanggal_transaksi', isset($data->tanggal_transaksi) ? \Carbon\Carbon::parse($data->tanggal_transaksi)->format('Y-m-d') : '') }}"
                         required>
                  @error('tanggal_transaksi')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                {{-- Nasabah --}}
                <div class="form-group">
                  <label class="font-weight-bold">Nasabah</label>
                  <select class="form-control custom-select @error('master_nasabah_id') is-invalid @enderror" 
                          name="master_nasabah_id" required>
                    <option value="" selected>- Pilih Nasabah -</option>
                    @foreach ($nasabah as $val)
                      <option value="{{ $val->id }}" 
                        {{ old('master_nasabah_id', $data->master_nasabah_id ?? '') == $val->id ? 'selected' : '' }}>
                        {{ $val->nama }}
                      </option>
                    @endforeach
                  </select>
                  @error('master_nasabah_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Jenis Sampah --}}
                <div class="form-group">
                  <label class="font-weight-bold">Jenis / Type</label>
                  <select class="form-control custom-select @error('master_jenis_sampah_id') is-invalid @enderror" 
                          name="master_jenis_sampah_id" required>
                    <option value="" selected>- Pilih Jenis -</option>
                    @foreach ($j_sampah as $val)
                      <option value="{{ $val->id }}" 
                        {{ old('master_jenis_sampah_id', $data->master_jenis_sampah_id ?? '') == $val->id ? 'selected' : '' }}>
                        {{ $val->type_sampah }}
                      </option>
                    @endforeach
                  </select>
                  @error('master_jenis_sampah_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Jumlah --}}
                <div class="form-group mb-3">
                  <label for="jumlah">Jumlah</label>
                  <input type="text" 
                         class="form-control @error('jumlah') is-invalid @enderror" 
                         id="jumlah" 
                         name="jumlah"
                         value="{{ old('jumlah', isset($data->jumlah) ? number_format($data->jumlah, 0, ',', '.') : '') }}"
                         placeholder="Masukkan jumlah" required>
                  @error('jumlah')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                {{-- Satuan --}}
                <div class="form-group">
                  <label class="font-weight-bold">Satuan</label>
                  <select class="form-control custom-select @error('master_satuan_id') is-invalid @enderror" 
                          name="master_satuan_id" required>
                    <option value="" selected>- Pilih Satuan -</option>
                    @foreach ($satuan as $val)
                      <option value="{{ $val->id }}" 
                        {{ old('master_satuan_id', $data->master_satuan_id ?? '') == $val->id ? 'selected' : '' }}>
                        {{ $val->satuan }}
                      </option>
                    @endforeach
                  </select>
                  @error('master_satuan_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-md btn-primary">
                  {{ $data ? 'UBAH' : 'SIMPAN' }}
                </button>
                <button type="reset" class="btn btn-md btn-warning">RESET</button>
                <a href="/transaksi/data-transaksi" class="btn btn-default float-right">KEMBALI</a>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

{{-- Script format ribuan --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jumlahInput = document.getElementById('jumlah');
    jumlahInput.addEventListener('input', function(e) {
        let angka = e.target.value.replace(/\D/g, '');
        e.target.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    });
});
</script>
@endsection
