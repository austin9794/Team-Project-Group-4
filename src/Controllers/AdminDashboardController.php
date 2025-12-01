<?php
if (!defined('ACCESS_ALLOWED')) {
    die('Direct access not permitted');
}

require_once __DIR__ . '/BaseAdminController.php';

class AdminDashboardController extends BaseAdminController {

    public function __construct() {
        // Call parent constructor to enforce authentication
        parent::__construct();
    }

    public function index() {
        // Dashboard display logic
        // This method will be called from the view
    }

    // TODO: Add functions related to the dashboard admin
    // Examples: fetchNotifications(), getLogs(), getSystemStats(), etc.
}
?>