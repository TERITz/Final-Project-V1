<?php
// ตรวจสอบว่าเป็นการส่งข้อมูลผ่านฟอร์ม (Method POST) หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เชื่อมต่อฐานข้อมูล
    $conn = getConnection(); 
    
    // --- [ด่านตรวจที่ 1: เช็คว่ากรอกข้อมูลครบทุกช่องหรือไม่] ---
    // สร้าง Array รายชื่อช่องทั้งหมดที่บังคับว่า "ห้ามว่าง"
    $required_fields = ['email', 'password', 'prefix', 'firstname', 'lastname', 'gender', 'birthdate', 'province'];
    
    foreach ($required_fields as $field) {
        // เช็คว่าไม่มีการส่งค่านั้นมา หรือ ส่งมาแต่เป็นค่าว่างเปล่า (แอบกด Spacebar ก็ไม่รอด!)
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            echo "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่องก่อนกดยืนยัน'); window.history.back();</script>";
            exit; // เตะกลับไปหน้าเดิมทันที
        }
    }

    // เมื่อผ่านด่านตรวจแรกมาได้ ค่อยรับค่าอีเมลมาใช้งาน
    $email = $_POST['email'];
    
    // --- [ด่านตรวจที่ 2: ขั้นตอนการตรวจสอบอีเมลซ้ำ] ---
    $check_sql = "SELECT email FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$email]);
    
    if ($check_stmt->fetch()) {
        echo "<script>alert('อีเมลนี้ถูกใช้งานไปแล้วครับ กรุณาลองใช้อีเมลอื่น'); window.history.back();</script>";
        exit;
    }

    // --- [ด่านตรวจที่ 3: ขั้นตอนการเตรียมข้อมูล] ---
    // เข้ารหัสรหัสผ่านเพื่อความปลอดภัย
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // ตอนนี้มั่นใจ 100% แล้วว่าตัวแปร $_POST ทุกตัวมีข้อมูลแน่นอน จับยัดใส่ Array ได้เลย
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

    // --- [ด่านสุดท้าย: บันทึกลงฐานข้อมูล] ---
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