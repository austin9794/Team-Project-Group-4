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
        $addressId = $_POST['address_id'] ?? null;

        $orderStmt = $db->prepare("
         INSERT INTO orders (user_id, total_price, status, address_id)
         VALUES (?, ?, 'pending', ?)
       ");
        $orderStmt->execute([$_SESSION['user_id'], $total, $addressId]);

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

    public function checkoutPage()
{
    requireLogin();
    $db = Database::getInstance()->getConnection();

    // FETCH USER INFO
    $userStmt = $db->prepare("SELECT * FROM users WHERE user_id = ?");
    $userStmt->execute([$_SESSION['user_id']]);
    $user = $userStmt->fetch();

    // FETCH SAVED ADDRESSES
    $addrStmt = $db->prepare("SELECT * FROM addresses WHERE user_id = ?");
    $addrStmt->execute([$_SESSION['user_id']]);
    $addresses = $addrStmt->fetchAll();

    // FETCH SAVED PAYMENT METHODS
    $payStmt = $db->prepare("SELECT * FROM payment_methods WHERE user_id = ?");
    $payStmt->execute([$_SESSION['user_id']]);
    $payments = $payStmt->fetchAll();

    // FETCH BASKET ITEMS
    $basketItems = [];
    $basketTotal = 0;

    foreach ($_SESSION['basket'] as $productId => $qty) {
        $stmt = $db->prepare("SELECT name, price, image FROM products WHERE product_id = ?");
        $stmt->execute([$productId]);
        $p = $stmt->fetch();
        
        if ($p) {
            $line = $p['price'] * $qty;

            $basketItems[] = [
                'name' => $p['name'],
                'quantity' => $qty,
                'total' => $line,
                'image' => $p['image']
            ];

            $basketTotal += $line;
        }
    }

    // PASS VARIABLES INTO TEMPLATE
    include __DIR__ . '/../../templates/customer/checkout.php';
}

public function listUserOrders()
{
    requireLogin();
    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare("
        SELECT * FROM orders 
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);

    $orders = $stmt->fetchAll();

    include __DIR__ . '/../../templates/customer/orders.php';
}

public function showOrder()
{
    if (!isset($_GET['id'])) {
        echo "Invalid order.";
        return;
    }

    if (!isset($_SESSION['user_id'])) {
        header("Location: /Team-Project-Group-4/public/index.php?page=login");
        exit;
    }

    $orderId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    $db = Database::getInstance()->getConnection();

    // Fetch order
    $orderStmt = $db->prepare("
        SELECT o.*, a.full_address
        FROM orders o
        LEFT JOIN addresses a ON o.address_id = a.address_id
        WHERE o.order_id = ? AND o.user_id = ?

    ");
    $orderStmt->execute([$orderId, $userId]);
    $order = $orderStmt->fetch();

    if (!$order) {
        echo "<h2>Order not found.</h2>";
        return;
    }

    // Fetch items
    $itemsStmt = $db->prepare("
        SELECT oi.*, pr.name, pr.image
        FROM order_items oi
        JOIN products pr ON oi.product_id = pr.product_id
        WHERE oi.order_id = ?
    ");
    $itemsStmt->execute([$orderId]);
    $items = $itemsStmt->fetchAll();

    include __DIR__ . '/../../templates/customer/order_detail.php';
}


}


