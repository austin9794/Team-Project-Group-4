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

    public function view() {
    $db = Database::getInstance()->getConnection();
    $id = (int)($_GET['id'] ?? 0);

    if (!$id) {
        header("Location: " . BASE_URL . "index.php?page=admin-messages");
        exit;
    }

    // Get message
    $stmt = $db->prepare("SELECT * FROM contact_messages WHERE id = ?");
    $stmt->execute([$id]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$message) {
        header("Location: " . BASE_URL . "index.php?page=admin-messages");
        exit;
    }

    // Mark as read
    $update = $db->prepare(" UPDATE contact_messages 
        SET status = 'read' 
        WHERE id = ?
    ");
    $update->execute([$id]);

    include __DIR__ . '/../../templates/admin/message_view.php';
  }
}