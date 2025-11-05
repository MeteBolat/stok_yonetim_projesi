<?php
require_once __DIR__ . '/../models/Product.php';

class DashboardController {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }

  public function index(){
    $stats = (new Product($this->pdo))->getAllStats();
    require __DIR__ . '/../views/dashboard_view.php';
  }
}
