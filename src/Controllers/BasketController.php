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

                // Fetch product from DB
                $stmt = $this->db->prepare("
                    SELECT product_id, name, price
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
                        'quantity' => $qty,
                        'total'    => $lineTotal
                    ];

                    $total += $lineTotal;
                }
            }
        }

        // Pass data to template
        $basketItems = $items;
        $basketTotal = $total;

        include __DIR__ . '/../../templates/customer/basket.php';
    }

    // ============================
    // ADD TO BASKET
    // ============================
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

    
