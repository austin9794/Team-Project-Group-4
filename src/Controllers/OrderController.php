<?php

class OrderController
{
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
}


