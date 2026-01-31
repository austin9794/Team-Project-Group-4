<?php

require_once __DIR__ . '/../Database.php';

class OrderController {

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

        // Calculate totals again for safety
      $total = 0;

     foreach ($_SESSION['basket'] as $productId => $qty) {
       $productId = (int)$productId;
       $qty = max(1, (int)$qty);

    $stmt = $db->prepare("SELECT price FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);
    $price = $stmt->fetchColumn();

    if ($price !== false) {
        $total += (float)$price * $qty;
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
    $addrStmt = $db->prepare("
       SELECT * FROM addresses 
       WHERE user_id = ?
       ORDER BY is_default DESC, created_at DESC
    ");
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
        $stmt = $db->prepare("
    SELECT 
        p.name,
        p.price,
        p.slug,
        c.name AS category
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.product_id = ?
");
$stmt->execute([$productId]);
$p = $stmt->fetch();

        
        if ($p) {
    $line = $p['price'] * $qty;

    $imagePath = "products/"
        . strtolower($p['category']) . "/"
        . $p['slug'] . "/01.png";

    $basketItems[] = [
        'name'     => $p['name'],
        'quantity' => $qty,
        'total'    => $line,
        'image'    => $imagePath
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
        SELECT 
          oi.*,
          pr.name,
          pr.slug,
          c.name AS category
        FROM order_items oi
        JOIN products pr ON oi.product_id = pr.product_id
        JOIN categories c ON pr.category_id = c.category_id
        WHERE oi.order_id = ?

    ");

    $itemsStmt->execute([$orderId]);
    $items = $itemsStmt->fetchAll();

    foreach ($items as &$item) {
    $item['image'] =
        "products/"
        . strtolower($item['category']) . "/"
        . $item['slug'] . "/01.png";
}


    include __DIR__ . '/../../templates/customer/order_detail.php';
}

public function adminProcessOrders()
{
    if (!isset($_POST['order_id'])) {
        echo "Missing order ID";
        return;
    }

    $orderId = (int)$_POST['order_id'];
    $db = Database::getInstance()->getConnection();

    try {
        $db->beginTransaction();

        
        $check = $db->prepare("
            SELECT status
            FROM orders
            WHERE order_id = ?
            FOR UPDATE
        ");
        $check->execute([$orderId]);
        $order = $check->fetch();

        if (!$order) {
            $db->rollBack();
            echo "Order not found.";
            return;
        }

        
        if ($order['status'] !== 'pending') {
            $db->commit();
            header("Location: /Team-Project-Group-4/public/index.php?page=admin-orders");
            exit;
        }

        
        $items = $db->prepare("
            SELECT product_id, quantity
            FROM order_items
            WHERE order_id = ?
        ");
        $items->execute([$orderId]);
        $rows = $items->fetchAll();

        foreach ($rows as $item) {
            $productId = (int)$item['product_id'];
            $quantity = (int)$item['quantity'];

            // Reduced stock
            $update = $db->prepare("
                UPDATE products
                SET stock = stock - ?
                WHERE product_id = ?
            ");
            $update->execute([$quantity, $productId]);

            
            $log = $db->prepare("
                INSERT INTO inventory_logs (product_id, change_amount, action, created_at)
                VALUES (?, ?, 'purchase', NOW())
            ");
            $log->execute([$productId, $quantity]);
        }

        
        $final = $db->prepare("
            UPDATE orders
            SET status = 'processing'
            WHERE order_id = ?
        ");
        $final->execute([$orderId]);

        $db->commit();

        header("Location: /Team-Project-Group-4/public/index.php?page=admin-orders");
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
}


