<?php

class OrderController
{
    public function placeOrder() {

    if (empty($_SESSION['basket'])) {
        header("Location: /Team-Project-Group-4/public/index.php?page=basket");
        exit;
    }

    if (!isset($_SESSION['user_id'])) {
        header("Location: /Team-Project-Group-4/public/index.php?page=login");
        exit;
    }

    $db = Database::getInstance()->getConnection();
}

// Calculate totals again for safety
    $total = 0;
    foreach ($_SESSION['basket'] as $productId => $qty) {
        $stmt = $db->prepare("SELECT price FROM products WHERE product_id = ?");
        $stmt->execute([$productId]);
        $price = $stmt->fetchColumn();
        if ($price) {
            $total += $price * $qty;
        }
    }

    
