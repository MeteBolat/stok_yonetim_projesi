<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';

$action = $_GET['action'] ?? 'products.index'; // default liste

switch ($action) {
  case 'products.index':
    (new ProductController($pdo))->index();         // liste + filtre + pagination
    break;

  case 'products.add.form':
    (new ProductController($pdo))->addForm();       // ekleme formu
    break;

  case 'products.add.do':
    (new ProductController($pdo))->addAction();     // ekleme POST
    break;

  case 'products.edit.form':
    (new ProductController($pdo))->editForm((int)($_GET['id'] ?? 0));
    break;

  case 'products.edit.do':
    (new ProductController($pdo))->editAction((int)($_GET['id'] ?? 0));
    break;

  case 'products.delete':
    (new ProductController($pdo))->deleteAction((int)($_GET['id'] ?? 0));
    break;

  case 'dashboard':
    (new DashboardController($pdo))->index();
    break;

  default:
    http_response_code(404);
    echo "404 Not Found";
}
