<?php

require_once __DIR__ . '/../Database.php';

class BasketController
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // SHOW BASKET PAGE
    
    public function index()
{
    $items = [];
    $total = 0;

    if (!empty($_SESSION['basket'])) {

        foreach ($_SESSION['basket'] as $productId => $qty) {

            // Fetch product info including image
            $stmt = $this->db->prepare("
                SELECT product_id, name, price, image
                FROM products
                WHERE product_id = ?
            ");
            $stmt->execute([$productId]);
            $product = $stmt->fetch();

            if ($product) {
                $lineTotal = $product['price'] * $qty;

                $items[] = [
                    'id'       => $product['product_id'],
                    'name'     => $product['name'],
                    'price'    => $product['price'],
                    'image'    => $product['image'], // <-- ADDED
                    'quantity' => $qty,
                    'total'    => $lineTotal
                ];

                $total += $lineTotal;
            }
        }
    }

    // Pass to template
    $basketItems = $items;
    $basketTotal = $total;

    include __DIR__ . '/../../templates/customer/basket.php';
}
 
    // ADD TO BASKET
    
    public function add()
    {
        $productId = $_POST['product_id'] ?? null;

        if (!$productId) {
            header("Location: /Team-Project-Group-4/public/index.php?page=products");
            exit;
        }

        // Initialize basket if not set
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        // Increment quantity
        $_SESSION['basket'][$productId] = ($_SESSION['basket'][$productId] ?? 0) + 1;

        header("Location: /Team-Project-Group-4/public/index.php?page=basket");
        exit;
    }

    
    // UPDATE QUANTITY
    
    public function update()
    {
        $productId = $_POST['product_id'] ?? null;
        $quantity  = (int) ($_POST['quantity'] ?? 0);

        if (!$productId) {
            header("Location: /Team-Project-Group-4/public/index.php?page=basket");
            exit;
        }

        if ($quantity <= 0) {
            unset($_SESSION['basket'][$productId]);
        } else {
            $_SESSION['basket'][$productId] = $quantity;
        }

        header("Location: /Team-Project-Group-4/public/index.php?page=basket");
        exit;
    }

    
    // REMOVE ITEM
    
    public function remove()
    {
        $productId = $_POST['product_id'] ?? null;

        if (isset($_SESSION['basket'][$productId])) {
            unset($_SESSION['basket'][$productId]);
        }

        header("Location: /Team-Project-Group-4/public/index.php?page=basket");
        exit;
    }

    public function showCheckout() {
    if (empty($_SESSION['basket'])) {
        header("Location: /Team-Project-Group-4/public/index.php?page=basket");
        exit;
    }

    $items = [];
    $total = 0;

    foreach ($_SESSION['basket'] as $productId => $qty) {

        $stmt = $this->db->prepare("
            SELECT product_id, name, price, image
            FROM products WHERE product_id = ?
        ");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();

        if ($product) {
            $line = $product['price'] * $qty;

            $items[] = [
                'id' => $productId,
                'name' => $product['name'],
                'quantity' => $qty,
                'total' => $line,
                'image' => $product['image']
            ];

            $total += $line;
        }
    }

        $basketItems = $items;
        $basketTotal = $total;

        include __DIR__ . '/../../templates/customer/checkout.php';
}

public function updateAjax()
{
    header('Content-Type: application/json');

    $productId = $_POST['product_id'] ?? null;
    $quantity  = (int)($_POST['quantity'] ?? 0);

    if (!$productId) {
        echo json_encode(['error' => 'No product ID']);
        return;
    }

    // Update basket
    if ($quantity <= 0) {
        unset($_SESSION['basket'][$productId]);
    } else {
        $_SESSION['basket'][$productId] = $quantity;
    }

    // Recalculate
    $db = Database::getInstance()->getConnection();
    $total = 0;
    $lineTotal = 0;

    // If item still exists, recalc its line total
    if ($quantity > 0) {
        $stmt = $db->prepare("SELECT price FROM products WHERE product_id = ?");
        $stmt->execute([$productId]);
        $price = $stmt->fetchColumn();

        $lineTotal = $price * $quantity;
    }

    // Recalc basket total
    foreach ($_SESSION['basket'] as $id => $qty) {
        $stmt = $db->prepare("SELECT price FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
        $price = $stmt->fetchColumn();
        $total += $price * $qty;
    }

    echo json_encode([
        'success'   => true,
        'productId' => $productId,
        'quantity'  => $quantity,
        'lineTotal' => number_format($lineTotal, 2),
        'total'     => number_format($total, 2),
        'remove'    => ($quantity <= 0)
    ]);
}

}
