<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">📦 Ürün Listesi</h2>
    <a href="/?action=dashboard" class="btn btn-info">📊 Dashboard Görüntüle</a>
  </div>

  <form method="GET" action="/" class="mb-4 d-flex gap-2">
    <input type="hidden" name="action" value="products.index">
    <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Ara..." class="form-control">
    <select name="category" class="form-select">
      <option value="">Tüm Kategoriler</option>
      <?php foreach (['Elektronik','Ev Ürünleri','Kişisel Bakım','Hırdavat','Gıda'] as $cat): ?>
        <option value="<?= $cat ?>" <?= (isset($category) && $category===$cat)?'selected':'' ?>><?= $cat ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn btn-primary">Filtrele</button>
  </form>

  <div class="mb-3 text-end">
    <a href="/?action=products.add.form" class="btn btn-success">➕ Yeni Ürün Ekle</a>
  </div>

  <table class="table table-striped table-bordered align-middle shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>İsim</th>
        <th>Kategori</th>
        <th>Fiyat</th>
        <th>Satış</th>
        <th>Stok</th>
        <th>İşlemler</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= htmlspecialchars($p['category']) ?></td>
          <td><?= number_format($p['price'],2) ?> ₺</td>
          <td><?= (int)$p['sales_count'] ?></td>
          <td><?= (int)$p['quantity'] ?></td>
          <td class="text-nowrap">
            <a href="/?action=products.edit.form&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
            <a href="/?action=products.delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğine emin misin?')">🗑️</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php
    $totalPages = ceil($total / 10);
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($totalPages > 1):
  ?>
  <nav>
    <ul class="pagination justify-content-center mt-4">
      <?php for ($i=1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i==$page?'active':'' ?>">
          <a class="page-link" href="<?= $paginationBase . $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
