
<?php
define('ACCESS_ALLOWED', true);
require_once __DIR__ . '/../../src/Controllers/AdminLoginController.php';
$controller = new AdminLoginController();
$error = $controller->processLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
</head>
<body>
    <div class="login-container">
       
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <div style="width: 20%; margin: auto;">
             <h2>Admin Login</h2>
 <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
        </div>
       
    </div>
</body>
</html>