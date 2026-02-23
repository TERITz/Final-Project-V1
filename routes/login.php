<?php
// routes/login.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getConnection(); // ได้ connection แบบ MySQLi
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    // 's' หมายถึง String (ข้อมูลที่จะใส่คือ email)
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // 5. แปลงข้อมูลเป็น Array (Fetch Assoc)
    $user = $result->fetch_assoc();

    // เช็คว่าเจอ user มั้ย และรหัสผ่านถูกมั้ย
    if ($user && password_verify($password, $user['password'])) {
        // ล็อกอินผ่าน! เก็บ Session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['firstname'] = $user['firstname'];
        
        // ตรงนี้อาจารย์อาจจะให้เช็ค role หรือไม่ก็ข้ามไปก่อน
        // $_SESSION['role'] = $user['role']; 

        header("Location: /"); // เด้งไปหน้าแรก
        exit;
    } else {
        echo "<script>alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง');</script>";
    }
}

renderView('login');
?>