<?php
require_once __DIR__ . '/src/Database.php';

header('Content-Type: application/json');

$q = $_GET['q'] ?? '';

if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

$db = Database::getInstance()->getConnection();

$stmt = $db->prepare(" SELECT product_id, name, slug
    FROM products
    WHERE name LIKE ?
    LIMIT 6
");

$stmt->execute(["%$q%"]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);