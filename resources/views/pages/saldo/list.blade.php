@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">

<!-- Header -->
<div class="content-header mb-5">
    <div class="container-fluid d-flex align-items-center gap-3">
        <!-- Icon di kiri dengan shadow -->
        <i class="fas fa-chart-line fa-3x text-success" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.2);"></i>
        
        <!-- Judul dan deskripsi -->
        <div class="d-flex flex-column">
            <h1 class="m-0" style="font-weight: 700; font-size: 2.2rem; line-height: 1.2;">Saldo Akhir</h1>
            <p class="text-muted mb-0" style="font-size: 1rem; line-height: 1.4;">Rekapitulasi semua transaksi Bank Sampah</p>
        </div>
    </div>
</div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            {{-- Card ringkasan saldo --}}
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-lg border-0 rounded-3 bg-gradient-success hover-scale">
                        <div class="card-body text-white d-flex flex-column align-items-center">
                            <i class="fas fa-wallet fa-2x mb-2"></i>
                            <h5>Pemasukan</h5>
                            <h3>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-lg border-0 rounded-3 bg-gradient-danger hover-scale">
                        <div class="card-body text-white d-flex flex-column align-items-center">
                            <i class="fas fa-credit-card fa-2x mb-2"></i>
                            <h5>Pengeluaran</h5>
                            <h3>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-lg border-0 rounded-3 bg-gradient-warning hover-scale">
                        <div class="card-body text-white d-flex flex-column align-items-center">
                            <i class="fas fa-cogs fa-2x mb-2"></i>
                            <h5>Operasional</h5>
                            <h3>Rp {{ number_format($totalOperasional, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-lg border-0 rounded-3 bg-gradient-primary hover-scale">
                        <div class="card-body text-white d-flex flex-column align-items-center">
                            <i class="fas fa-coins fa-2x mb-2"></i>
                            <h5>Saldo Akhir</h5>
                            <h2>Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik transaksi --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-lg rounded-3 border-0">
                        <div class="card-header bg-gradient-info text-white d-flex align-items-center position-relative py-3 px-4">
                            
                            {{-- Judul chart di kiri --}}
                            <div id="chartTitle" class="fw-bold" style="font-size: 1.2rem;">
                                Grafik Saldo Akhir
                            </div>
                            
                            {{-- Dropdown pilih grafik --}}
                            <div class="dropdown-wrapper">
                                <select id="chartSelector" 
                                        class="form-select form-select-sm rounded-pill border-0 shadow-sm w-auto bg-white text-dark">
                                    <option value="saldo">💰 Saldo Akhir</option>
                                    <option value="pemasukan">⭐ Top 10 Nasabah</option>
                                </select>
                            </div>

                        </div>
                        <div class="card-body p-4">
                            <canvas id="transaksiChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartTitle = document.getElementById('chartTitle');
const ctx = document.getElementById('transaksiChart').getContext('2d');

// Data Saldo Akhir
const saldoData = {
    labels: @json($labels),
    datasets: [{
        label: 'Saldo Akhir',
        data: @json($data),
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderWidth: 2,
        tension: 0.4,
        fill: true,
        pointBackgroundColor: '#fff',
        pointBorderColor: 'rgba(54,162,235,1)',
        pointRadius: 5
    }]
};

// Data Top 10 Nasabah
const topNasabahData = {
    labels: @json($topNasabah->pluck('nama')),
    datasets: [{
        label: 'Total Transaksi',
        data: @json($topNasabah->pluck('nominal')),
        backgroundColor: 'rgba(40, 167, 69, 0.7)',
        borderColor: 'rgba(25, 135, 84, 1)',
        borderWidth: 1
    }]
};

// Fungsi untuk buat chart
function createChart(type, data) {
    return new Chart(ctx, {
        type: type,
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50000,
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
}

// Inisialisasi chart default (Saldo Akhir)
let transaksiChart = createChart('line', saldoData);

// Event dropdown
document.getElementById('chartSelector').addEventListener('change', function() {
    const value = this.value;
    transaksiChart.destroy();

    if(value === 'saldo') {
        chartTitle.textContent = 'Grafik Saldo Akhir';
        transaksiChart = createChart('line', saldoData);
    } else if(value === 'pemasukan') {
        chartTitle.textContent = 'Top 10 Nasabah';
        transaksiChart = createChart('bar', topNasabahData);
    }
});
</script>

<style>
.dropdown-wrapper {
    margin-left: auto; /* paksa dorong ke kanan */
}

/* Hover effect untuk card ringkasan */
.hover-scale {
    transition: transform 0.3s, box-shadow 0.3s;
}
.hover-scale:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* Shadow lebih lembut untuk chart card */
.card-body canvas {
    border-radius: 8px;
}

/* Pilihan dropdown */
#chartSelector {
    cursor: pointer;
    transition: transform 0.2s;
}
#chartSelector:hover {
    transform: scale(1.05);
}
</style>
@endpush
