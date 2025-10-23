<?php
// Central configuration for DB and admin
// Update ADMIN_EMAIL to your admin account email

// Database connection
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'quiz';

// Admin email (change to your email)
$ADMIN_EMAIL = 'gowthamgg4248@gmail.com';

// Helper: get mysqli connection
function db_connect() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if (!$conn) {
        die('Database connection failed');
    }
    return $conn;
}

// Helper: is current session user admin
function is_admin() {
    global $ADMIN_EMAIL;
    return isset($_SESSION['user_email']) && strtolower($_SESSION['user_email']) === strtolower($ADMIN_EMAIL);
}

?>


