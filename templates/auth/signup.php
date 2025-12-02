<?php
session_start();

define('ACCESS_ALLOWED', true);
require "Database.php";

$db = Database::getInstance()->getConnection();

$error = "";
$success = "";

if (isset($_POST['signup'])) {

$name      = trim($_POST['name']);
$email     = trim($_POST['email']);
$password  = trim($_POST['password']);
$confirm   = trim($_POST['confirm']);
$phone     = trim($_POST['phone']);
$address   = trim($_POST['address']);

// Validation
if ($password !== $confirm) {
    $error = "Passwords do not match.";
} elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters.";
} else {

    // Check if email exists
    $check = $db->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $error = "An account with this email already exists.";
    } else {

        // ❗ NO HASHING (MVP ONLY – unsafe for production)
        $plainPassword = $password;

        // Insert new user
        $insert = $db->prepare("
            INSERT INTO users (name, email, password, phone, address, role)
            VALUES (?, ?, ?, ?, ?, 'customer')
        ");

        if ($insert->execute([$name, $email, $plainPassword, $phone, $address])) {
            $success = "Your account has been created! Please log in.";
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}


}
?>

<!DOCTYPE html>
<html>
<head>
<title>Sign Up - LevelUp</title>

<style>
body {
background:#1a0b2e; /* Deep purple */
font-family: Arial, sans-serif;
color:#eee;
}

.container {
width: 420px;
margin: 70px auto;
background:#2a0f47; /* Purple card */
padding: 25px;
border-radius: 12px;
box-shadow: 0 0 20px rgba(132, 0, 255, 0.4);
}

h2 {
text-align:center;
color:#d9a7ff; /* Soft lilac */
margin-bottom:20px;
font-weight: bold;
}

input, textarea {
width:100%;
padding:12px;
margin:10px 0;
border-radius:6px;
border:1px solid #5d3b8a;
background:#3a165d;
color:white;
}

input::placeholder, textarea::placeholder {
color:#c9a8ff;
}

button {
width:100%;
padding:12px;
background:#8f3dff; /* Purple neon */
color:white;
border:none;
border-radius:6px;
cursor:pointer;
font-weight:bold;
transition:0.3s;
}

button:hover {
background:#b46cff;
}

.error {
color:#ff6b6b;
text-align:center;
}

.success {
color:#6bff8f;
text-align:center;
}

a {
text-align:center;
display:block;
margin-top:12px;
color:#d8b6ff;
}

a:hover {
color:white;
}
</style>

</head>

<body>

<div class="container">

<h2>Create Your LevelUp Account</h2>

<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>

<form method="POST">
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email Address" required>
<input type="password" name="password" placeholder="Create Password" required>
<input type="password" name="confirm" placeholder="Confirm Password" required>
<input type="text" name="phone" placeholder="Phone Number (optional)">
<textarea name="address" placeholder="Home Address (optional)"></textarea>
<button type="submit" name="signup">Create Account</button>
</form>

<a href="login.php">Already have an account? Log in</a>

</div>

</body>
</html>