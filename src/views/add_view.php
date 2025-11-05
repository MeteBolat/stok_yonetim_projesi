<?php require_once __DIR__ . '/../includes/header.php'; ?>

<h3 class="mb-4">➕ Yeni Ürün Ekle</h3>

<form method="POST" action="/?action=products.add.do">
  <div class="mb-3">
    <label class="form-label">Ürün Adı</label>
    <input type="text" name="name" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="category" class="form-select" required>
      <?php foreach (['Elektronik','Ev Ürünleri','Kişisel Bakım','Hırdavat','Gıda'] as $cat): ?>
        <option value="<?= $cat ?>"><?= $cat ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Fiyat (₺)</label>
    <input type="number" step="0.01" name="price" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Stok Miktarı</label>
    <input type="number" name="quantity" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-success">Kaydet</button>
  <a href="/?action=products.index" class="btn btn-secondary">İptal</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
