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
<?php include __DIR__ . '/../footer.php'; ?>