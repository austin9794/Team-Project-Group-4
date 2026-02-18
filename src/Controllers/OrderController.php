<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Helpers/address.php';

class OrderController {

    public function placeOrder() {   
        $addressId = null;

        if (empty($_SESSION['basket'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=basket");
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=login");
            exit;
        }

        // VALIDATE PAYMENT METHOD 
        if (empty($_POST['payment_id'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=checkout&error=no_payment");
            exit;
        }

        $db = Database::getInstance()->getConnection();

        // Ensure user has address
        $addressCheck = $db->prepare(" SELECT COUNT(*) FROM addresses
          WHERE user_id = ?
        ");
        $addressCheck->execute([$_SESSION['user_id']]);
        $hasAddress = $addressCheck->fetchColumn() > 0;

        // Ensure user has payment
        $paymentCheck = $db->prepare(" SELECT COUNT(*) FROM payment_methods
         WHERE user_id = ?
        ");
        $paymentCheck->execute([$_SESSION['user_id']]);
        $hasPayment = $paymentCheck->fetchColumn() > 0;

        if (!$hasAddress || !$hasPayment) {
          header("Location: " . BASE_URL . "index.php?page=checkout&error=incomplete_checkout");
        exit;
}

        //Payment Validation
        if (empty($_POST['payment_id'])) {
        header("Location: /Team-Project-Group-4/public/index.php?page=checkout&error=no_payment");
        exit;
     }

        $paymentId = (int) $_POST['payment_id'];

        $payStmt = $db->prepare(" SELECT card_brand, card_last4
           FROM payment_methods
           WHERE payment_id = ? AND user_id = ?
       ");
        $payStmt->execute([$paymentId, $_SESSION['user_id']]);
        $payment = $payStmt->fetch();

       if (!$payment) {
         header("Location: /Team-Project-Group-4/public/index.php?page=checkout&error=invalid_payment");
         exit;
        }

       $paymentSummary = $payment['card_brand'] . ' ending ' . $payment['card_last4'];

       //Address Validation
       $addressId = $_SESSION['checkout_address_id'] ?? null;

        if ($addressId) {

        // Fetch snapshot from selected address
        $addrStmt = $db->prepare(" SELECT *
            FROM addresses
            WHERE address_id = ? AND user_id = ?
        ");

        $addrStmt->execute([$addressId, $_SESSION['user_id']]);
        $address = $addrStmt->fetch();
        } else {

         // Auto-select default address
        $addrStmt = $db->prepare(" SELECT *
            FROM addresses
            WHERE user_id = ? AND is_default = 1
            LIMIT 1
        ");
        $addrStmt->execute([$_SESSION['user_id']]);
        $address = $addrStmt->fetch();
       }

      if (!$address) {
         header("Location: /Team-Project-Group-4/public/index.php?page=checkout&error=no_address");
         exit;
        }

        $addressId        = $address['address_id'];
        $shippingAddress  = formatAddress($address);

    // Recalculate total
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

    //Order Snapshot
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
        $_SESSION['user_id'],
        $total,
        $addressId,
        $shippingAddress,
        $paymentSummary
   ]);

     $orderId = $db->lastInsertId();

    //Order Items
    foreach ($_SESSION['basket'] as $productId => $qty) {
        $stmt = $db->prepare("SELECT price FROM products WHERE product_id = ?");
        $stmt->execute([$productId]);
        $price = $stmt->fetchColumn();

        $insert = $db->prepare(" INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
            VALUES (?, ?, ?, ?)
        ");
        $insert->execute([$orderId, $productId, $qty, $price]);
    }

    //Clean up and redirect
    unset($_SESSION['basket']);
    unset($_SESSION['checkout_address_id']);

    header("Location: /Team-Project-Group-4/public/index.php?page=order-success&id=" . $orderId);
    exit;

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
        header("Location: /Team-Project-Group-4/public/index.php?page=login");
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

public function adminProcessOrders() {
    if (!isset($_POST['order_id'])) {
        echo "Missing order ID";
        return;
    }

    $orderId = (int)$_POST['order_id'];
    $db = Database::getInstance()->getConnection();

    try {
        $db->beginTransaction();

        
        $check = $db->prepare(" SELECT status
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

        
        $items = $db->prepare(" SELECT product_id, quantity
            FROM order_items
            WHERE order_id = ?
        ");
        $items->execute([$orderId]);
        $rows = $items->fetchAll();

        foreach ($rows as $item) {
            $productId = (int)$item['product_id'];
            $quantity = (int)$item['quantity'];

            // Reduced stock
            $update = $db->prepare(" UPDATE products
                SET stock = stock - ?
                WHERE product_id = ?
            ");
            $update->execute([$quantity, $productId]);

            
            $log = $db->prepare("INSERT INTO inventory_logs (product_id, change_amount, action, created_at)
                VALUES (?, ?, 'purchase', NOW())
            ");
            $log->execute([$productId, $quantity]);
        }

        
        $final = $db->prepare(" UPDATE orders
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

    header("Location: " . BASE_URL . "index.php?page=orders");
    exit;
}

public function showReturnForm()
{
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


