<?php
session_start();
define('ACCESS_ALLOWED', true);
require "Database.php";

$db = Database::getInstance()->getConnection();

$error = "";

if (isset($_POST["login"])) {

```
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

$query = $db->prepare("SELECT * FROM users WHERE email = ?");
$query->execute([$email]);

if ($query->rowCount() === 1) {
    $user = $query->fetch();

    // Plain text password check (MVP only)
    if ($password === $user['password']) {

        $_SESSION['uid']  = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect to homepage instead of dashboard
        header("Location: index.php");
        exit();
    }
}

$error = "Invalid email or password.";

```

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - LevelUp</title>

<style>
body {
background:#1a0b2e;
font-family:Arial, sans-serif;
color:#eee;
}

.container {
width: 420px;
margin: 80px auto;
background:#2a0f47;
padding: 25px;
border-radius: 12px;
box-shadow: 0 0 20px rgba(132, 0, 255, 0.4);
}

h2 {
text-align:center;
margin-bottom:20px;
color:#d9a7ff;
font-weight:bold;
}

input {
width:100%;
padding:12px;
margin:10px 0;
border-radius:6px;
border:1px solid #5d3b8a;
background:#3a165d;
color:white;
}

input::placeholder { color:#c9a8ff; }

button {
width:100%;
padding:12px;
background:#8f3dff;
border:none;
border-radius:6px;
color:white;
cursor:pointer;
font-weight:bold;
transition:0.3s;
}

button:hover { background:#b46cff; }

.error {
color:#ff6b6b;
text-align:center;
}

a {
display:block;
text-align:center;
color:#d8b6ff;
margin-top:12px;
}

a:hover { color:white; }
</style>

</head>

<body>

<div class="container">

<h2>Login to LevelUp</h2>

<?php if ($error): ?>
<p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
<input type="email" name="email" placeholder="Email Address" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="login">Login</button>
</form>

<a href="signup.php">Create a new account</a>

</div>
</body>
</html>