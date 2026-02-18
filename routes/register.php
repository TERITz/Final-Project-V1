<?php
// ถ้ามีการกดปุ่ม Submit (Method เป็น POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getConnection(); // เรียกใช้ฟังก์ชันจาก includes/database.php
    
    // รับค่าจากฟอร์ม
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $data = [
        $_POST['email'],
        $password,
        $_POST['prefix'],
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['gender'],
        $_POST['birthdate'],
        $_POST['province']
    ];

    try {
        $sql = "INSERT INTO users (email, password, prefix, firstname, lastname, gender, birthdate, province) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);

        // สมัครเสร็จแล้วให้เด้งไปหน้า Login
        echo "<script>alert('สมัครสมาชิกสำเร็จ!'); window.location.href='/login';</script>";
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Error: อีเมลนี้อาจมีคนใช้แล้ว หรือข้อมูลผิดพลาด');</script>";
    }
}

// ถ้าเปิดเข้ามาปกติ (GET) ให้แสดงหน้าฟอร์ม
renderView('register');