<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminProductController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function products() {
        $db = Database::getInstance()->getConnection();
        
        // Initialize variables
        $products = [];
        $categories = [];



    