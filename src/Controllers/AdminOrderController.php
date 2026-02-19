<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminOrderController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {