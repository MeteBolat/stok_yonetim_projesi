<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
  private $pdo;
  private $product;

  public function __construct($pdo) {
    $this->pdo = $pdo;
    $this->product = new Product($pdo);
  }

  public function index() {
    $search   = $_GET['search']   ?? '';
    $category = $_GET['category'] ?? '';
    $page     = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit    = 10;
    $offset   = ($page - 1) * $limit;

    $products = $this->product->getProducts($search, $category, $limit, $offset);
    $total    = $this->product->getTotalCount($search, $category);

    // view değişkenleri
    $paginationBase = '/?action=products.index&search='.urlencode($search).'&category='.urlencode($category).'&page=';

    require __DIR__ . '/../views/index_view.php';
  }

  public function addForm() {
    require __DIR__ . '/../views/add_view.php';
  }

  public function addAction() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: /?action=products.index'); exit;
    }
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = (float)($_POST['price'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 0);

    $this->product->addProduct($name, $category, $price, $quantity);
    header('Location: /?action=products.index'); exit;
  }

  public function editForm(int $id) {
    if ($id <= 0) { header('Location: /?action=products.index'); exit; }
    $product = $this->product->getProductById($id);
    if (!$product) { header('Location: /?action=products.index'); exit; }
    require __DIR__ . '/../views/edit_view.php';
  }

  public function editAction(int $id) {
    if ($id <= 0 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: /?action=products.index'); exit;
    }
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = (float)($_POST['price'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 0);

    $this->product->updateProduct($id, $name, $category, $price, $quantity);
    header('Location: /?action=products.index'); exit;
  }

  public function deleteAction(int $id) {
    if ($id > 0) { $this->product->deleteProduct($id); }
    header('Location: /?action=products.index'); exit;
  }
}
