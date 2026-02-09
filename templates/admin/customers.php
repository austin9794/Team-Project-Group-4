<?php include __DIR__ . '/../header.php'; ?>

<h1>Customer Management</h1>

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