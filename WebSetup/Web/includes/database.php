<?php

$hostname = 'sql12.freesqldatabase.com';
$dbName = 'sql12821110';
$username = 'sql12821110';
$password = 'GFqgSkJtEl';
$conn = new mysqli($hostname, $username, $password, $dbName);

function getConnection(): mysqli
{
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // เซ็ต timezone ให้ MySQL ใช้เวลาไทย
    $conn->query("SET time_zone = '+07:00'");
    
    return $conn;
}

// database functions ต่างๆ
//require_once DATABASES_DIR . '/user.php';
require_once __DIR__ . '/../database/user.php';
require_once __DIR__ . '/../database/event.php';
require_once __DIR__ . '/../database/registrations.php';
