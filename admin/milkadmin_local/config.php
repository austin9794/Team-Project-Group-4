<?php
/**
 * MilkAdmin Configuration File
 * Database and Application Settings
 */
!defined('MILK_DIR') && die(); // Avoid direct access

// ========== DATABASE CONFIGURATION ==========
// XAMPP MySQL Settings
$conf['db_type'] = 'mysql';
$conf['db_host'] = 'localhost';
$conf['db_port'] = '3306';
$conf['db_user'] = 'root';
$conf['db_pass'] = '';  // XAMPP default - empty password
$conf['db_name'] = 'team_project_db';
$conf['db_prefix'] = 'tp_';
$conf['db_charset'] = 'utf8mb4';

// ========== BASE URL CONFIGURATION ==========
$temp = $_SERVER['REQUEST_URI'];
if (strpos($temp, '?') !== false) {
    $temp = substr($temp, 0, strpos($temp, '?'));
}
if (strpos($temp, '.php') !== false) {
    $temp = dirname($temp);
}
if (substr($temp, -1) != '/') {
    $temp .= '/';
}
$conf['base_url'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $temp;

// ========== APPLICATION SETTINGS ==========
$conf['home_page'] = '?page=home';
$conf['page_not_found'] = '404';
$conf['debug'] = true;
$conf['site-title'] = 'Team Project - E-Commerce Platform';

// ========== SECURITY SETTINGS ==========
$conf['session_timeout'] = 3600;
$conf['password_hash'] = 'bcrypt';

// ========== FILE UPLOAD SETTINGS ==========
$conf['upload_max_size'] = 5242880; // 5MB
$conf['allowed_upload_types'] = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

\App\Config::setAll($conf);