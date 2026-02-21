<?php
// database/users.php

// ฟังก์ชันสำหรับเช็ค Login
// database/users.php

function checkLogin(string $email, string $password)
{
    $conn = getConnection(); 
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ถ้าเจอ User และรหัสผ่านตรงกัน
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

// ฟังก์ชันสำหรับสมัครสมาชิก
function registerUser($data)
{
    $conn = getConnection();
    $sql = "INSERT INTO users (email, password, prefix, firstname, lastname, gender, birthdate, province) 
            VALUES (:email, :password, :prefix, :firstname, :lastname, :gender, :birthdate, :province)";
    
    $stmt = $conn->prepare($sql);
    
    // Hash รหัสผ่านก่อนเก็บ
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

    return $stmt->execute([
        ':email' => $data['email'],
        ':password' => $hashed_password,
        ':prefix' => $data['prefix'],
        ':firstname' => $data['firstname'],
        ':lastname' => $data['lastname'],
        ':gender' => $data['gender'],
        ':birthdate' => $data['birthdate'],
        ':province' => $data['province']
    ]);
}
?>