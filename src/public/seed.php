<?php
require_once '../config/db.php';

// Ürün listesi
$products = [
    ['iPhone 15', 'Elektronik', 45999.00],
    ['Samsung TV 55"', 'Elektronik', 23999.00],
    ['Dyson Süpürge', 'Ev Ürünleri', 12499.00],
    ['Philips Tıraş Makinesi', 'Kişisel Bakım', 1999.00],
    ['Çekiç Seti', 'Hırdavat', 399.00],
    ['Makarna 500g', 'Gıda', 24.99],
    ['Lenovo Laptop', 'Elektronik', 18999.00],
    ['Blender', 'Ev Ürünleri', 999.00],
    ['Tefal Tava', 'Ev Ürünleri', 349.00],
    ['Kulaklık', 'Elektronik', 799.00],
    ['Kahve Makinesi', 'Ev Ürünleri', 1599.00],
    ['Saç Kurutma Makinesi', 'Kişisel Bakım', 499.00],
    ['Matkap', 'Hırdavat', 599.00],
    ['Pirinç 1kg', 'Gıda', 32.99],
    ['Samsung Galaxy S23', 'Elektronik', 37999.00],
    ['HP Yazıcı', 'Elektronik', 1499.00],
    ['Mikser', 'Ev Ürünleri', 899.00],
    ['Traş Makinesi', 'Kişisel Bakım', 299.00],
    ['Çekiç', 'Hırdavat', 79.00],
    ['Bulaşık Deterjanı', 'Gıda', 12.99],
    ['MacBook Air', 'Elektronik', 24999.00],
    ['Tablet Samsung', 'Elektronik', 7999.00],
    ['Tost Makinesi', 'Ev Ürünleri', 699.00],
    ['Şampuan', 'Kişisel Bakım', 59.99],
    ['Vida Seti', 'Hırdavat', 49.99],
    ['Un 1kg', 'Gıda', 14.99],
    ['iPad', 'Elektronik', 18999.00],
    ['Elektrikli Süpürge', 'Ev Ürünleri', 1499.00],
    ['Parfüm', 'Kişisel Bakım', 399.00],
    ['Matkap Ucu Seti', 'Hırdavat', 89.00],
    ['Çikolata', 'Gıda', 9.99],
    ['Monitör 27"', 'Elektronik', 3499.00],
    ['Fırın', 'Ev Ürünleri', 2999.00],
    ['Diş Fırçası', 'Kişisel Bakım', 19.99],
    ['Benzin Testere', 'Hırdavat', 1299.00],
    ['Peynir 500g', 'Gıda', 49.99],
    ['Hoparlör', 'Elektronik', 699.00],
    ['Buzdolabı', 'Ev Ürünleri', 10999.00],
    ['Tıraş Bıçağı', 'Kişisel Bakım', 149.00],
    ['Çivi Seti', 'Hırdavat', 29.99],
    ['Makarna Sosu', 'Gıda', 24.99],
    ['Akıllı Saat', 'Elektronik', 2999.00],
    ['Mikrodalga', 'Ev Ürünleri', 1799.00],
    ['Losyon', 'Kişisel Bakım', 79.99],
    ['Kablo Seti', 'Hırdavat', 59.00],
    ['Ekmek', 'Gıda', 9.99],
    ['Oyun Konsolu', 'Elektronik', 5999.00],
    ['Su Isıtıcı', 'Ev Ürünleri', 349.00],
    ['Tıraş Makinesi Yedek', 'Kişisel Bakım', 199.00],
    ['Matkap Aküsü', 'Hırdavat', 249.00],
    ['Yoğurt 1kg', 'Gıda', 19.99],
    ['Mouse', 'Elektronik', 299.00],
    ['Tost Makinesi Deluxe', 'Ev Ürünleri', 899.00],
];

foreach ($products as $p) {
    $stmt = $pdo->prepare("SELECT id FROM products WHERE name = ? AND category = ?");
    $stmt->execute([$p[0], $p[1]]);
    $product_id = $stmt->fetchColumn();

    $sales_count = rand(5, 300);
    if (!$product_id) {
        $stmt2 = $pdo->prepare("INSERT INTO products (name, category, price, sales_count) VALUES (?, ?, ?, ?)");
        $stmt2->execute([$p[0], $p[1], $p[2], $sales_count]);
        $product_id = $pdo->lastInsertId();

        $quantity = rand(0, 100);
        $pdo->prepare("INSERT INTO stocks (product_id, quantity) VALUES (?, ?)")->execute([$product_id, $quantity]);
    } else {
        $pdo->prepare("UPDATE products SET sales_count = ? WHERE id = ?")->execute([$sales_count, $product_id]);
    }
}

echo "✅ Seed verileri başarıyla eklendi (sales_count dahil)!";
