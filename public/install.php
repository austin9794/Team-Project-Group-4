<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "ecommerce_db";

// === BLOCK REINSTALLATION IF DB EXISTS ===
try {
    $check = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    echo "<h2 style='color:red;text-align:center;'>Database already exists!</h2>";
    echo "<p style='text-align:center;'>If you really want to reinstall, drop the database manually in phpMyAdmin.</p>";
    exit;
} catch (PDOException $e) {
    
}

// CONNECT TO MYSQL WITHOUT SELECTING A DATABASE
try {
    $pdo = new PDO("mysql:host=$DB_HOST", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("<h2>Connection failed:</h2>" . $e->getMessage());
}

// CREATE DATABASE
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$DB_NAME`");
    $pdo->exec("USE `$DB_NAME`");
    echo "<p>✔ Database '$DB_NAME' created or already exists.</p>";
} catch (PDOException $e) {
    die("<h3>Error creating database:</h3>" . $e->getMessage());
}

// IMPORT SQL FILES
function importSQL($pdo, $filePath)
{
    if (!file_exists($filePath)) {
        echo "<p style='color:red;'>✘ File not found: $filePath</p>";
        return false;
    }

    $sql = file_get_contents($filePath);

    try {
        $pdo->exec($sql);
        echo "<p>✔ Imported: $filePath</p>";
        return true;
    } catch (PDOException $e) {
        echo "<p style='color:red;'>✘ Error importing $filePath:<br>" . $e->getMessage() . "</p>";
        return false;
    }
}

$root = realpath(__DIR__ . "/.."); // Project root

importSQL($pdo, "$root/sql/schema.sql");
importSQL($pdo, "$root/sql/seed_data.sql");


//  COMPLETION MESSAGE
echo "<h2 style='color:green;text-align:center;margin-top:40px;'>Installation Complete!</h2>";
echo "<p style='text-align:center;'>You may now use the website normally.</p>";
echo "<p style='text-align:center;'><a href='index.php'>Go to Homepage</a></p>";

?>

