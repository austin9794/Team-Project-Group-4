<?php

require_once __DIR__ . '/BaseAdminController.php';
require_once __DIR__ . '/../Database.php';

class AdminContactController extends BaseAdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->query(" SELECT *
            FROM contact_messages
            ORDER BY created_at DESC
        ");

        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../templates/admin/contact_messages.php';
    }
}