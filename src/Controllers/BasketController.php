<?php

require_once __DIR__ . '/../Database.php';

class BasketController
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // =========================
    // SHOW BASKET
    // =========================
    public function index()
    {
        $items = [];
        $total = 0;

        if (!empty($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $productId => $qty) {

                $stmt = $this->db->prepare(" SELECT 
                        p.product_id,
                        p.name,
                        p.price,
                        p.slug,
                        c.name AS category
                    FROM products p
                    JOIN categories c ON p.category_id = c.category_id
                    WHERE p.product_id = ?
                ");
                $stmt->execute([$productId]);
                $product = $stmt->fetch();

                if (!$product) continue;

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
    public function add()
    {
        $productId = $_POST['product_id'] ?? null;
        if (!$productId) {
            header("Location: index.php?page=products");
            exit;
        }

        $_SESSION['basket'][$productId] =
            ($_SESSION['basket'][$productId] ?? 0) + 1;

        header("Location: index.php?page=basket");
        exit;
    }

    // =========================
    // UPDATE QUANTITY
    // =========================
    public function update()
    {
        $productId = $_POST['product_id'] ?? null;
        $quantity  = (int)($_POST['quantity'] ?? 0);

        if (!$productId) {
            header("Location: index.php?page=basket");
            exit;
        }

        if ($quantity <= 0) {
            unset($_SESSION['basket'][$productId]);
        } else {
            $_SESSION['basket'][$productId] = $quantity;
        }

        header("Location: index.php?page=basket");
        exit;
    }

    // =========================
    // REMOVE ITEM
    // =========================
    public function remove()
    {
        $productId = $_POST['product_id'] ?? null;
        unset($_SESSION['basket'][$productId]);

        header("Location: index.php?page=basket");
        exit;
    }

    // =========================
    // CHECKOUT PAGE
    // =========================
    public function showCheckout()
    {
        if (empty($_SESSION['basket'])) {
            header("Location: index.php?page=basket");
            exit;
        }

        $items = [];
        $total = 0;

        foreach ($_SESSION['basket'] as $productId => $qty) {

            $stmt = $this->db->prepare("  SELECT 
                    p.product_id,
                    p.name,
                    p.price,
                    p.slug,
                    c.name AS category
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_id = ?
            ");
            $stmt->execute([$productId]);
            $product = $stmt->fetch();

            if (!$product) continue;

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
    public function updateAjax()
    {
        header('Content-Type: application/json');

        $productId = $_POST['product_id'] ?? null;
        $quantity  = (int)($_POST['quantity'] ?? 0);

        if (!$productId) {
            echo json_encode(['error' => 'No product ID']);
            return;
        }

        if ($quantity <= 0) {
            unset($_SESSION['basket'][$productId]);
        } else {
            $_SESSION['basket'][$productId] = $quantity;
        }

        $total = 0;
        $lineTotal = 0;

        if ($quantity > 0) {
            $stmt = $this->db->prepare("SELECT price FROM products WHERE product_id = ?");
            $stmt->execute([$productId]);
            $price = $stmt->fetchColumn();
            $lineTotal = $price * $quantity;
        }

        foreach ($_SESSION['basket'] as $id => $qty) {
            $stmt = $this->db->prepare("SELECT price FROM products WHERE product_id = ?");
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
