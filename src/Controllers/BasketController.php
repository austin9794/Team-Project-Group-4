<?php

require_once __DIR__ . '/../Database.php';

class BasketController
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    private function getProductsByIds($ids)
{
    if (empty($ids)) return [];

    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $this->db->prepare(" SELECT 
            p.product_id,
            p.name,
            p.price,
            p.slug,
            c.name AS category
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        WHERE p.product_id IN ($placeholders)
    ");

    $stmt->execute($ids);

    $products = [];
    foreach ($stmt->fetchAll() as $row) {
        $products[$row['product_id']] = $row;
    }

    return $products;
}

    // =========================
    // SHOW BASKET
    // =========================
    public function index()
    {
        $items = [];
        $total = 0;

        if (!empty($_SESSION['basket'])) {

    $productIds = array_keys($_SESSION['basket']);
    $products = $this->getProductsByIds($productIds);

    foreach ($_SESSION['basket'] as $productId => $qty) {

        if (!isset($products[$productId])) continue;

        $product = $products[$productId];

        $lineTotal = $product['price'] * $qty;

        $imagePath = "products/"
            . strtolower($product['category']) . "/"
            . $product['slug'] . "/01.png";

        $items[] = [
            'id'       => $product['product_id'],
            'name'     => $product['name'],
            'price'    => $product['price'],
            'image'    => $imagePath,
            'quantity' => $qty,
            'total'    => $lineTotal
        ];

        $total += $lineTotal;
    }
}

        $basketItems = $items;
        $basketTotal = $total;

        include __DIR__ . '/../../templates/customer/basket.php';
    }

    // =========================
    // ADD TO BASKET
    // =========================
    public function add() {

    $productId = $_POST['product_id'] ?? null;
    $quantity  = (int)($_POST['quantity'] ?? 1);

    if (!$productId) {
        header("Location: " . BASE_URL . "index.php?page=products");
        exit;
    }

    if ($quantity < 1) {
        $quantity = 1;
    }

    // Get stock level
    $stmt = $this->db->prepare("SELECT stock FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);
    $stock = (int)$stmt->fetchColumn();

    if ($stock <= 0) {

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
            echo json_encode([
                "success" => false,
                "message" => "Product is out of stock"
            ]);
            exit;
        }

        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=products'));
        exit;
    }

    // Current basket quantity
    $currentQty = $_SESSION['basket'][$productId] ?? 0;

    // Clamp quantity to available stock
    $newQty = min($currentQty + $quantity, $stock);

    $_SESSION['basket'][$productId] = $newQty;

    // AJAX response
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){

        echo json_encode([
            "success" => true,
            "basketCount" => array_sum($_SESSION['basket']),
            "clamped" => ($newQty < $currentQty + $quantity)
        ]);

        exit;
    }

    // redirect back
    $back = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=products';
    header("Location: " . $back);
    exit;
}

    // =========================
    // UPDATE QUANTITY
    // =========================
    public function update() {

    $productId = $_POST['product_id'] ?? null;
    $quantity  = (int)($_POST['quantity'] ?? 0);

    if (!$productId) {
        header("Location: " . BASE_URL . "index.php?page=basket");
        exit;
    }

    // Get stock
    $stmt = $this->db->prepare("SELECT stock FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);
    $stock = (int)$stmt->fetchColumn();

    if ($quantity <= 0) {
        unset($_SESSION['basket'][$productId]);
    } else {

        // Clamp to stock
        $quantity = min($quantity, $stock);
        $_SESSION['basket'][$productId] = $quantity;
    }

    header("Location: " . BASE_URL . "index.php?page=basket");
    exit;
}

    // =========================
    // REMOVE ITEM
    // =========================
    public function remove()
    {
        $productId = $_POST['product_id'] ?? null;
        unset($_SESSION['basket'][$productId]);

        header("Location: " . BASE_URL . "index.php?page=basket");
        exit;
    }

    // =========================
    // CHECKOUT PAGE
    // =========================
    public function showCheckout()
    {
        if (empty($_SESSION['basket'])) {
            header("Location: " . BASE_URL . "index.php?page=basket");
            exit;
        }

        $items = [];
        $total = 0;

        $productIds = array_keys($_SESSION['basket']);
        $products = $this->getProductsByIds($productIds);

foreach ($_SESSION['basket'] as $productId => $qty) {

    if (!isset($products[$productId])) continue;

    $product = $products[$productId];

    $line = $product['price'] * $qty;

    $imagePath = "products/"
        . strtolower($product['category']) . "/"
        . $product['slug'] . "/01.png";

    $items[] = [
        'id'       => $productId,
        'name'     => $product['name'],
        'quantity' => $qty,
        'total'    => $line,
        'image'    => $imagePath
    ];

    $total += $line;
}

        $basketItems = $items;
        $basketTotal = $total;

        include __DIR__ . '/../../templates/customer/checkout.php';
    }

    // =========================
    // AJAX UPDATE
    // =========================
    public function updateAjax() {
        
    header('Content-Type: application/json');

    $productId = $_POST['product_id'] ?? null;
    $quantity  = (int)($_POST['quantity'] ?? 0);

    if (!$productId) {
        echo json_encode(['success' => false, 'message' => 'No product ID']);
        return;
    }

    // Fetch product (stock + price)
    $stmt = $this->db->prepare("SELECT stock, price FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        return;
    }

    $stock = (int)$product['stock'];
    $price = (float)$product['price'];

    // Handle removal or update
    if ($quantity <= 0) {
        unset($_SESSION['basket'][$productId]);
        $quantity = 0;
        $lineTotal = 0;
        $clamped = false;
    } else {
        // Clamp to stock
        $originalQty = $quantity;
        $quantity = min($quantity, $stock);
        $_SESSION['basket'][$productId] = $quantity;

        $lineTotal = $price * $quantity;
        $clamped = ($quantity < $originalQty);
    }

    // Recalculate basket total efficiently
    $total = 0;

    if (!empty($_SESSION['basket'])) {
        $products = $this->getProductsByIds(array_keys($_SESSION['basket']));

        foreach ($_SESSION['basket'] as $id => $qty) {
            if (!isset($products[$id])) continue;

            $total += $products[$id]['price'] * $qty;
        }
    }

    echo json_encode([
        'success'     => true,
        'productId'   => $productId,
        'quantity'    => $quantity,
        'lineTotal'   => number_format($lineTotal, 2),
        'total'       => number_format($total, 2),
        'basketCount' => array_sum($_SESSION['basket'] ?? []),
        'remove'      => ($quantity === 0),
        'clamped'     => $clamped
    ]);
  }   
}
