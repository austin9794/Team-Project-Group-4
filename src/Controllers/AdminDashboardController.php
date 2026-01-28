<?php

require_once __DIR__ . '/BaseAdminController.php';

class AdminDashboardController extends BaseAdminController {

    public function __construct() {
        // Call parent constructor 
        parent::__construct();
    }

    public function index() {
        // Dashboard display logic
        // This method will be called from the view
    }

    // functions related to the dashboard admin
    // fetchNotifications(), getLogs(), getSystemStats(), etc.
}
?>