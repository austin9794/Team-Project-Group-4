<?php
define('ACCESS_ALLOWED', true);

//This dashboard will include a navigation bar to other admin pages functions. The admin page will show various notifcations and logs about orders and changes to the system, such as the database.

require_once __DIR__ . '/../../src/Controllers/AdminDashboardController.php';

// Instantiate the controller - this automatically checks authentication
$controller = new AdminDashboardController();
// You can call controller methods here, e.g., $controller->index();
?>

<?php include __DIR__ . '/../header.php'; ?>
<h2>Admin Dashboard</h2>
<p>This is the Admin Dashboard — routing confirmed!</p>
<p>Welcome, <?php echo htmlspecialchars($controller->getAdminName()); ?>!</p>

<h3>Quick Links</h3>
<ul>
    <li><a href="/Team-Project-Group-4/public/index.php?page=admin-orders">View Orders</a></li>
    <li><a href="/Team-Project-Group-4/public/index.php?page=admin-products">View Products</a></li>
    <li><a href="/Team-Project-Group-4/public/index.php?page=admin-customers">View Customers</a></li>
</ul>

<?php include __DIR__ . '/../footer.php'; ?>