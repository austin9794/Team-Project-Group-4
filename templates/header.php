<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/Helpers/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'E-Commerce Platform' ?></title>
</head>
<body>
<nav>
    <a href="index.php?page=home">Home</a> |
    <a href="index.php?page=login">Login</a> |
    <a href="index.php?page=dashboard">Dashboard</a>
</nav>
<hr>
