<?php
class Product {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }

  public function getProducts($search='', $category='', $limit=10, $offset=0){
    $params = [];
    $where  = "WHERE 1";

    if ($search)   { $where .= " AND p.name LIKE ?"; $params[] = "%$search%"; }
    if ($category) { $where .= " AND p.category = ?"; $params[] = $category; }

    $sql = "
      SELECT p.id, p.name, p.category, p.price, p.sales_count, s.quantity, p.created_at
      FROM products p
      LEFT JOIN stocks s ON p.id = s.product_id
      $where
      ORDER BY p.created_at DESC
      LIMIT ? OFFSET ?
    ";
    $params[] = (int)$limit;
    $params[] = (int)$offset;

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getTotalCount($search='', $category=''){
    $params = [];
    $where  = "WHERE 1";
    if ($search)   { $where .= " AND name LIKE ?"; $params[] = "%$search%"; }
    if ($category) { $where .= " AND category = ?"; $params[] = $category; }

    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products $where");
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
  }

  public function getAllStats(){
    $stmt = $this->pdo->query("
      SELECT p.name, p.sales_count, s.quantity, p.price
      FROM products p
      JOIN stocks s ON p.id = s.product_id
      ORDER BY p.sales_count DESC
      LIMIT 10
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function addProduct($name, $category, $price, $quantity){
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("INSERT INTO products (name, category, price) VALUES (?, ?, ?)");
      $stmt->execute([$name, $category, $price]);
      $productId = (int)$this->pdo->lastInsertId();

      $this->pdo->prepare("INSERT INTO stocks (product_id, quantity) VALUES (?, ?)")
                ->execute([$productId, $quantity]);

      $this->pdo->commit();
    } catch (\Throwable $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }

  public function getProductById($id){
    $stmt = $this->pdo->prepare("
      SELECT p.id, p.name, p.category, p.price, s.quantity
      FROM products p
      JOIN stocks s ON p.id = s.product_id
      WHERE p.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updateProduct($id, $name, $category, $price, $quantity){
    $this->pdo->beginTransaction();
    try {
      $this->pdo->prepare("UPDATE products SET name=?, category=?, price=? WHERE id=?")
                ->execute([$name, $category, $price, $id]);

      $this->pdo->prepare("UPDATE stocks SET quantity=? WHERE product_id=?")
                ->execute([$quantity, $id]);

      $this->pdo->commit();
    } catch (\Throwable $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }

  public function deleteProduct($id){
    // ON DELETE CASCADE var ise stocks otomatik düşer; yoksa stocks'u önce sil
    $this->pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
  }
}
