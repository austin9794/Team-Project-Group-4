<?php

require_once __DIR__ . '/../Database.php';

class OrderController {

    public function placeOrder() {   // <-- THIS MUST EXIST, and must open correctly

        if (empty($_SESSION['basket'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=basket");
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=login");
            exit;
        }

        $db = Database::getInstance()->getConnection();

        // Calculate totals again for safety
        $total = 0;   // <-- THIS WILL WORK ONLY IF INSIDE A METHOD

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

        // Insert order items
        foreach ($_SESSION['basket'] as $productId => $qty) {
            $stmt = $db->prepare("SELECT price FROM products WHERE product_id = ?");
            $stmt->execute([$productId]);
            $price = $stmt->fetchColumn();

            $insert = $db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
                VALUES (?, ?, ?, ?)
            ");
            $insert->execute([$orderId, $productId, $qty, $price]);
        }

        // Clear basket
        unset($_SESSION['basket']);

        // Redirect to success page
        header("Location: /Team-Project-Group-4/public/index.php?page=order-success&id=" . $orderId);
        exit;
    }
}


