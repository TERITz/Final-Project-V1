<?php

$hostname = 'localhost';
$dbName = 'event_registration_db';
$username = 'final';
$password = '1235';
$conn = new mysqli($hostname, $username, $password, $dbName);

function getConnection(): mysqli
{
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// database functions ต่างๆ
//require_once DATABASES_DIR . '/user.php';
require_once __DIR__ . '/../database/user.php';
require_once __DIR__ . '/../database/event.php';
require_once __DIR__ . '/../database/registrations.php';