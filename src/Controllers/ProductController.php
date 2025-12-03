<?php
require_once __DIR__ . '/../Database.php';

class ProductController {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // LIST ALL PRODUCTS OR FILTERED PRODUCTS
   
    public function list() {

        $filters = [
            'category' => $_GET['category'] ?? null,
            'search' => $_GET['search'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null
        ];

   // Base query
        $sql = "
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE 1=1
        ";
        $params = [];


    // SEARCH FILTER
        if (!empty($filters['search'])) {
            $sql .= " AND p.name LIKE ? ";
            $params[] = "%" . $filters['search'] . "%";
        }