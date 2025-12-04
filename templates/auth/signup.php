require "AuthController.php";
$auth = new AuthController();
$success = "";
$error = "";

if (isset($_POST['signup'])) {
    $result = $auth->register(
        trim($_POST['name']),
        trim($_POST['email']),
        trim($_POST['password']),
        trim($_POST['phone']),
        trim($_POST['address'])
    );

    if ($result === true) {
        $success = "Account created successfully! Please log in.";
    } else {
        $error = $result;
    }
}
