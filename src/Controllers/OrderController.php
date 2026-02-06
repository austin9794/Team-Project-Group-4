<?php

require_once __DIR__ . '/../Database.php';

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

        // VALIDATE ADDRESS
        if (empty($_POST['address_id']) && empty($_POST['manual_address'])) {
            header("Location: /Team-Project-Group-4/public/index.php?page=checkout&error=no_address");
            exit;
        }

        $db = Database::getInstance()->getConnection();

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
    $addrStmt = $db->prepare("
        SELECT address_id, full_address
        FROM addresses
        WHERE address_id = ? AND user_id = ?
    ");
    $addrStmt->execute([$addressId, $_SESSION['user_id']]);
    $address = $addrStmt->fetch();
    } else {

     // Auto-select default address
    $addrStmt = $db->prepare(" SELECT address_id, full_address
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
    $shippingAddress  = $address['full_address'];

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

    // Use address chosen during checkout
    if (!empty($_SESSION['checkout_address_id'])) {
        foreach ($addresses as $addr) {
            if ($addr['address_id'] == $_SESSION['checkout_address_id']) {
                $selectedAddress = $addr;
                break;
            }
        }
    }

    // Fallback to default address
    if (!$selectedAddress) {
        foreach ($addresses as $addr) {
            if ($addr['is_default']) {
                $selectedAddress = $addr;
                break;
            }
        }
    }

    // Payments 
    $payStmt = $db->prepare(" SELECT *
        FROM payment_methods
        WHERE user_id = ?
        ORDER BY is_default DESC, created_at DESC
    ");
    $payStmt->execute([$_SESSION['user_id']]);
    $paymentMethods = $payStmt->fetchAll();




    
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

    $db = Database::getInstance()->getConnection();

    // Fetch order
    $orderStmt = $db->prepare(" SELECT o.*, a.full_address
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
}


