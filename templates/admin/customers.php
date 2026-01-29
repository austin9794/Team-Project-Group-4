<?php include __DIR__ . '/../header.php'; ?>

<h1>Customer Management</h1>

<?php
require_once __DIR__ . '/../../src/Database.php';
$db = Database::getInstance()->getConnection();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_customer'])) {
    $userId = (int)$_POST['user_id'];
    $delete = $db->prepare("DELETE FROM users WHERE user_id = ? AND role != 'admin'");
    $delete->execute([$userId]);
    header("Location: /Team-Project-Group-4/public/index.php?page=admin-customers");
    exit;
}

// Fetch all customers
$stmt = $db->prepare("SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC");
$stmt->execute();
$customers = $stmt->fetchAll();
?>

<h2>All Customers</h2>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Joined</th>
    <th>Actions</th>
  </tr>

  <?php if (empty($customers)): ?>
    <tr>
      <td colspan="7">No customers found.</td>
    </tr>
  <?php else: ?>
    <?php foreach ($customers as $customer): ?>
      <tr>
        <td><?= (int)$customer['user_id'] ?></td>
        <td><?= htmlspecialchars($customer['name']) ?></td>
        <td><?= htmlspecialchars($customer['email']) ?></td>
        <td><?= htmlspecialchars($customer['phone'] ?? '-') ?></td>
        <td><?= htmlspecialchars($customer['address'] ?? '-') ?></td>
        <td><?= htmlspecialchars($customer['created_at']) ?></td>
        <td>
          <a href="/Team-Project-Group-4/public/index.php?page=admin-customer-edit&id=<?= (int)$customer['user_id'] ?>">Edit</a>
          
          <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this customer?');">
            <input type="hidden" name="user_id" value="<?= (int)$customer['user_id'] ?>">
            <button type="submit" name="delete_customer">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</table>

<?php include __DIR__ . '/../footer.php'; ?>