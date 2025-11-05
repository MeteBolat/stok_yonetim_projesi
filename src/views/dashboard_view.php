<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">📊 Satış & Stok Analizi</h3>
    <a href="index.php" class="btn btn-secondary">🏠 Ürün Listesine Dön</a>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-center mb-3">🛒 En Çok Satan Ürünler</h5>
          <canvas id="salesChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-center mb-3">📦 Stok Durumu</h5>
          <canvas id="stockChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-center mb-3">💰 Fiyat Dağılımı</h5>
          <canvas id="priceChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 👇 Grafiklerin boyutunu sınırlıyoruz -->
<style>
  canvas {
    width: 100% !important;
    height: 250px !important;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const stats = <?= json_encode($stats) ?>;

// Ortak chart seçenekleri
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: { legend: { display: false } },
  scales: { x: { ticks: { autoSkip: true, maxTicksLimit: 4 } } }
};

new Chart(document.getElementById('salesChart'), {
  type: 'bar',
  data: {
    labels: stats.map(x => x.name),
    datasets: [{ label: 'Satış', data: stats.map(x => x.sales_count), backgroundColor: 'rgba(54,162,235,0.7)' }]
  },
  options: chartOptions
});

new Chart(document.getElementById('stockChart'), {
  type: 'bar',
  data: {
    labels: stats.map(x => x.name),
    datasets: [{ label: 'Stok', data: stats.map(x => x.quantity), backgroundColor: 'rgba(255,206,86,0.7)' }]
  },
  options: chartOptions
});

new Chart(document.getElementById('priceChart'), {
  type: 'bar',
  data: {
    labels: stats.map(x => x.name),
    datasets: [{ label: 'Fiyat (₺)', data: stats.map(x => x.price), backgroundColor: 'rgba(75,192,192,0.7)' }]
  },
  options: chartOptions
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
