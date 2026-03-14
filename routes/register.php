<?php
// ตรวจสอบว่าเป็นการส่งข้อมูลผ่านฟอร์ม (POST) หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เชื่อมต่อฐานข้อมูล
    $conn = getConnection(); 
    
    // 1 เช็คว่ากรอกข้อมูลครบทุกช่องหรือไม่
    // สร้าง Array รายชื่อช่องทั้งหมด
    $required_fields = ['email', 'password', 'prefix', 'firstname', 'lastname', 'gender', 'birthdate', 'province'];
    
    foreach ($required_fields as $field) {
        // เช็คว่าไม่มีการส่งค่านั้นมา หรือ ส่งมาแต่เป็นค่าว่างเปล่า
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            echo "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่องก่อนกดยืนยัน'); window.history.back();</script>";
            exit; // กลับไปหน้าเดิมทันที
        }
    }

    // เมื่อผ่านส่วนที่ 1 ก็รับค่าอีเมลมาใช้งาน
    $email = $_POST['email'];
    
    // 2 ขั้นตอนการตรวจสอบอีเมลซ้ำ
    $check_sql = "SELECT email FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
	$check_stmt->execute();
    
    if ($check_stmt->fetch()) {
        echo "<script>alert('อีเมลนี้ถูกใช้งานไปแล้วครับ กรุณาลองใช้อีเมลอื่น'); window.history.back();</script>";
        exit;
    }

    // 3 ขั้นตอนการเตรียมข้อมูล
    // เข้ารหัสรหัสผ่านเพื่อความปลอดภัย
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // จับใส่ Array เพราะทุกตัวมีข้อมูลแล้วแน่นอน
    $data = [
        $email,
        $password,
        $_POST['prefix'],
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['gender'],
        $_POST['birthdate'],
        $_POST['province']
    ];

    // บันทึกลงฐานข้อมูล
    try {
        $sql = "INSERT INTO users (email, password, prefix, firstname, lastname, gender, birthdate, province) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);

        echo "<script>alert('สมัครสมาชิกเรียบร้อยแล้ว'); window.location.href='/login';</script>";
        exit;

    } catch (Exception $e) {
        echo "<script>alert('เกิดข้อผิดพลาดบางอย่าง: " . $e->getMessage() . "'); window.history.back();</script>";
        exit;
    }
}

// ถ้าเป็นการเปิดหน้าเว็บปกติ (ไม่ได้ส่งฟอร์ม) ให้แสดงหน้าสมัครสมาชิก
renderView('register');
?>