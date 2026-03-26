<?php
// database/users.php

// ฟังก์ชันสำหรับเช็ค Login
// database/users.php

function getUserById($id) {
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE user_id = ?"; // เช็คชื่อคอลัมน์ user_id ให้ตรงกับ DB
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getUserByEmail($email) {
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function createUser($email, $password, $prefix, $firstname, $lastname, $gender, $birthdate, $province) {
    $conn = getConnection();
    $sql = "INSERT INTO users (email, password, prefix, firstname, lastname, gender, birthdate, province) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $email, $password, $prefix, $firstname, $lastname, $gender, $birthdate, $province);
    return $stmt->execute();
}
?>