<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Helpers/address.php';

class OrderController {

public function placeOrder() {

    if (empty($_SESSION['basket'])) {
        header("Location: " . BASE_URL . "index.php?page=basket");
        exit;
    }

    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "index.php?page=login");
        exit;
    }

    if (empty($_POST['payment_id'])) {
        header("Location: " . BASE_URL . "index.php?page=checkout&error=no_payment");
        exit;
    }

    $db = Database::getInstance()->getConnection();

    try {
        $db->beginTransaction();

        $userId = $_SESSION['user_id'];
        $basket = $_SESSION['basket'];

        // =========================
        // VALIDATE PAYMENT
        // =========================
        $paymentId = (int) $_POST['payment_id'];

        $payStmt = $db->prepare(" SELECT card_brand, card_last4
            FROM payment_methods
            WHERE payment_id = ? AND user_id = ?
        ");
        $payStmt->execute([$paymentId, $userId]);
        $payment = $payStmt->fetch();

        if (!$payment) {
            throw new Exception("Invalid payment method");
        }

        $paymentSummary = $payment['card_brand'] . ' ending ' . $payment['card_last4'];

        // =========================
        // VALIDATE ADDRESS
        // =========================
        $addressId = $_SESSION['checkout_address_id'] ?? null;

        if ($addressId) {
            $addrStmt = $db->prepare(" SELECT *
                FROM addresses
                WHERE address_id = ? AND user_id = ?
            ");
            $addrStmt->execute([$addressId, $userId]);
        } else {
            $addrStmt = $db->prepare(" SELECT *
                FROM addresses
                WHERE user_id = ? AND is_default = 1
                LIMIT 1
            ");
            $addrStmt->execute([$userId]);
        }

        $address = $addrStmt->fetch();

        if (!$address) {
            throw new Exception("No valid address found");
        }

        $shippingAddress = formatAddress($address);

        // =========================
        // LOCK PRODUCTS + VALIDATE STOCK
        // =========================
        $productIds = array_keys($basket);
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

        $stmt = $db->prepare(" SELECT product_id, price, stock
            FROM products
            WHERE product_id IN ($placeholders)
            FOR UPDATE
        ");
        $stmt->execute($productIds);

        $products = [];
        foreach ($stmt->fetchAll() as $p) {
            $products[$p['product_id']] = $p;
        }

        $subtotal = 0;

        foreach ($basket as $productId => $qty) {

            if (!isset($products[$productId])) {
                throw new Exception("Product not found");
            }

            $product = $products[$productId];

            if ($product['stock'] < $qty) {
                throw new Exception("Some items are out of stock or changed quantity");
            }

            $subtotal += $product['price'] * $qty;
        }

        // =========================
        // CALCULATE TOTAL
        // =========================
        $shipping = ($subtotal >= 50) ? 0 : 4.99;
        $vat = $subtotal * 0.20;
        $total = $subtotal + $shipping + $vat;

        // =========================
        // INSERT ORDER
        // =========================
        $orderStmt = $db->prepare(" INSERT INTO orders (
                user_id,
                total_price,
                status,
                address_id,
                shipping_address,
                payment_summary
            ) VALUES (?, ?, 'pending', ?, ?, ?)
        ");

        $orderStmt->execute([
            $userId,
            $total,
            $address['address_id'],
            $shippingAddress,
            $paymentSummary
        ]);

        $orderId = $db->lastInsertId();

        // =========================
        // INSERT ITEMS + UPDATE STOCK
        // =========================
        $insertItem = $db->prepare(" INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
            VALUES (?, ?, ?, ?)
        ");

        $updateStock = $db->prepare("UPDATE products
            SET stock = stock - ?
            WHERE product_id = ?
        ");

        foreach ($basket as $productId => $qty) {
            $product = $products[$productId];

            $insertItem->execute([
                $orderId,
                $productId,
                $qty,
                $product['price']
            ]);

            $updateStock->execute([
                $qty,
                $productId
            ]);
        }

        // =========================
        // COMMIT
        // =========================
        $db->commit();

        // Clean session
        unset($_SESSION['basket']);
        unset($_SESSION['checkout_address_id']);

        header("Location: " . BASE_URL . "index.php?page=order-success&id=" . $orderId);
        exit;

    } catch (Exception $e) {

        $db->rollBack();

        $_SESSION['checkout_error'] = $e->getMessage();

        header("Location: " . BASE_URL . "index.php?page=checkout");
        exit;
    }
}

    public function checkoutPage() {
    requireLogin();
    $db = Database::getInstance()->getConnection();

    // User
     $userStmt = $db->prepare("SELECT * FROM users WHERE user_id = ?");
    $userStmt->execute([$_SESSION['user_id']]);
    $userData = $userStmt->fetch();

    $addrStmt = $db->prepare(" SELECT *
        FROM addresses
        WHERE user_id = ?
        ORDER BY is_default DESC, created_at DESC
    ");
    $addrStmt->execute([$_SESSION['user_id']]);
    $addresses = $addrStmt->fetchAll();

    // Determine which address checkout should show
    $selectedAddress = null;

   // Address selected in checkout session
if (!empty($_SESSION['checkout_address_id'])) {
    foreach ($addresses as $addr) {
        if ($addr['address_id'] == $_SESSION['checkout_address_id']) {
            $selectedAddress = $addr;
            break;
        }
    }
}

//Default address
if (!$selectedAddress) {
    foreach ($addresses as $addr) {
        if (!empty($addr['is_default'])) {
            $selectedAddress = $addr;
            break;
        }
    }
}

// First available address (fallback)
if (!$selectedAddress && !empty($addresses)) {
    $selectedAddress = $addresses[0];
}


    // Payments 
    $payStmt = $db->prepare(" SELECT *
        FROM payment_methods
        WHERE user_id = ?
        ORDER BY is_default DESC, created_at DESC
    ");
    $payStmt->execute([$_SESSION['user_id']]);
    $paymentMethods = $payStmt->fetchAll();

    // Basket
    $basketItems = [];
    $basketTotal = 0;

    foreach ($_SESSION['basket'] as $productId => $qty) {
        $stmt = $db->prepare(" SELECT p.name, p.price, p.slug, c.name AS category
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.product_id = ?
        ");
        $stmt->execute([$productId]);
        $p = $stmt->fetch();

        if ($p) {
            $line = $p['price'] * $qty;

            $basketItems[] = [
                'name'     => $p['name'],
                'quantity' => $qty,
                'total'    => $line,
            ];

            $basketTotal += $line;
        }
    }

    // Include template
    include __DIR__ . '/../../templates/customer/checkout.php';
    
}

public function listUserOrders()
{
    requireLogin();
    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare(" SELECT * FROM orders 
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
        header("Location: " . BASE_URL . "index.php?page=login");
        exit;
    }

    $orderId = $_GET['id'];
    $userId = $_SESSION['user_id'];
    $isAdmin = $_SESSION['is_admin'] ?? false;

    $db = Database::getInstance()->getConnection();

    // Fetch order
    $orderStmt = $db->prepare(" SELECT o.*
        FROM orders o
        LEFT JOIN addresses a ON o.address_id = a.address_id
        LEFT JOIN payment_methods pm ON o.payment_id = pm.payment_id
        WHERE o.order_id = ? AND o.user_id = ?

    ");
    $orderStmt->execute([$orderId, $userId]);
    $order = $orderStmt->fetch();

    if (!$order) {
        echo "<h2>Order not found.</h2>";
        return;
    }

    // Fetch items
    $itemsStmt = $db->prepare(" SELECT 
        oi.*,
        pr.name,
        pr.slug,
        c.name AS category,
        COALESCE(SUM(r.quantity), 0) AS returned_qty,
        MAX(r.status) AS return_status
    FROM order_items oi
    JOIN products pr ON oi.product_id = pr.product_id
    JOIN categories c ON pr.category_id = c.category_id
    LEFT JOIN returns r ON r.order_item_id = oi.order_item_id
    WHERE oi.order_id = ?
    GROUP BY oi.order_item_id
");


    $itemsStmt->execute([$orderId]);
    $items = $itemsStmt->fetchAll();

    foreach ($items as $i => $item) {
    $items[$i]['image'] =
        "products/"
        . strtolower($item['category']) . "/"
        . $item['slug'] . "/01.png";
}


    include __DIR__ . '/../../templates/customer/order_detail.php';
}

public function selectCheckoutAddress()
{
    requireLogin();

    if (empty($_POST['address_id'])) {
        header("Location: " . BASE_URL . "index.php?page=checkout-address&error=invalid");
        exit;
    }

    $addressId = (int)$_POST['address_id'];

    $db = Database::getInstance()->getConnection();

    // Ensure address belongs to user
    $stmt = $db->prepare(" SELECT address_id
        FROM addresses
        WHERE address_id = ? AND user_id = ?
    ");
    $stmt->execute([$addressId, $_SESSION['user_id']]);

    if (!$stmt->fetch()) {
        header("Location: " . BASE_URL . "index.php?page=checkout-address&error=unauthorized");
        exit;
    }

    // Store selection in session
    $_SESSION['checkout_address_id'] = $addressId;

    header("Location: " . BASE_URL . "index.php?page=checkout");
    exit;
}

public function checkoutAddressPage()
{
    requireLogin();

    $db = Database::getInstance()->getConnection();

    // Fetch user's addresses
    $stmt = $db->prepare(" SELECT *
        FROM addresses
        WHERE user_id = ?
        ORDER BY is_default DESC, created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $addresses = $stmt->fetchAll();

    include __DIR__ . '/../../templates/customer/checkout_address.php';
}

public function submitReturn() {
    requireLogin();
    $db = Database::getInstance()->getConnection();

    $itemId  = (int)$_POST['order_item_id'];
    $qty     = (int)$_POST['quantity'];
    $reason  = trim($_POST['reason']);

    // Fetch order item + order
    $stmt = $db->prepare("  SELECT oi.*, o.created_at, o.user_id
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.order_id
        WHERE oi.order_item_id = ? AND o.user_id = ?
    ");
    $stmt->execute([$itemId, $_SESSION['user_id']]);
    $item = $stmt->fetch();

    if (!$item) exit("Invalid return request");

    // 7-day rule
    if (strtotime($item['created_at']) < strtotime('-7 days')) {
        exit("Return window expired");
    }

    // Quantity validation
    $available = $item['quantity'] - $item['returned_quantity'];
    if ($qty < 1 || $qty > $available) {
        exit("Invalid return quantity");
    }

    // Insert return
    $insert = $db->prepare(" INSERT INTO returns (order_id, order_item_id, user_id, quantity, reason)
        VALUES (?, ?, ?, ?, ?)
    ");
    $insert->execute([
        $item['order_id'],
        $itemId,
        $_SESSION['user_id'],
        $qty,
        $reason
    ]);

    header("Location: " . BASE_URL . "index.php?page=return-success");
    exit;
}

public function showReturnForm() {
    requireLogin();
    $db = Database::getInstance()->getConnection();

    $itemId = (int)($_GET['item'] ?? 0);

    $stmt = $db->prepare(" SELECT oi.*, pr.name, o.created_at
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.order_id
        JOIN products pr ON oi.product_id = pr.product_id
        WHERE oi.order_item_id = ? AND o.user_id = ?
    ");
    $stmt->execute([$itemId, $_SESSION['user_id']]);
    $item = $stmt->fetch();

    if (!$item) exit("Invalid item");

    include __DIR__ . '/../../templates/customer/request_return.php';
}


}


