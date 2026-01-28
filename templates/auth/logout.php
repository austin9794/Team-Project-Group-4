<?php
session_start();
define('ACCESS_ALLOWED', true);

require "Database.php";
require "AuthController.php";

$auth = new AuthController();
$auth->logout();
?>
