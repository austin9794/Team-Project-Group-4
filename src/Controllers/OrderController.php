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

    // Insert into orders table
    $orderStmt = $db->prepare("
        INSERT INTO orders (user_id, total_price, status)
        VALUES (?, ?, 'pending')
    ");
    $orderStmt->execute([$_SESSION['user_id'], $total]);

    $orderId = $db->lastInsertId();

    // Insert each item into order_items
    foreach ($_SESSION['basket'] as $productId => $qty) {

        $priceStmt = $db->prepare("SELECT price FROM products WHERE product_id = ?");
        $priceStmt->execute([$productId]);
        $price = $priceStmt->fetchColumn();

        $itemInsert = $db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
            VALUES (?, ?, ?, ?)
        ");
        $itemInsert->execute([$orderId, $productId, $qty, $price]);
    }

    // Clear basket after placing the order
    unset($_SESSION['basket']);

    // Redirect to order confirmation page
    header("Location: /Team-Project-4/public/index.php?page=order-success&id=" . $orderId);
    exit;
}