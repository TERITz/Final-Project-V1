<?php
// ตรวจสอบว่าเป็นการส่งข้อมูลผ่านฟอร์ม (Method POST) หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เชื่อมต่อฐานข้อมูล
    $conn = getConnection(); 
    
    // รับค่าอีเมลจากฟอร์มเพื่อนำมาเช็คซ้ำ
    $email = $_POST['email'];
    
    // --- [1. ขั้นตอนการตรวจสอบอีเมลซ้ำ] ---
    // เตรียมคำสั่ง SQL เพื่อหาว่ามีอีเมลนี้ในระบบแล้วหรือยัง
    $check_sql = "SELECT email FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$email]);
    
    // ถ้าผลการค้นหาพบว่ามีอีเมลนี้อยู่แล้ว (ซ้ำ)
    if ($check_stmt->fetch()) {
        // แสดงหน้าต่างแจ้งเตือน (Alert) และย้อนกลับไปหน้าเดิม (window.history.back)
        // การย้อนกลับแบบนี้จะช่วยรักษาข้อมูลที่ผู้ใช้กรอกค้างไว้ และไม่ทำให้เกิด Error พ่นหน้าเว็บ
        echo "<script>alert('อีเมลนี้ถูกใช้งานไปแล้วครับ กรุณาลองใช้อีเมลอื่น'); window.history.back();</script>";
        exit; // หยุดการทำงานทันที
    }

    // --- [2. ขั้นตอนการเตรียมข้อมูล] ---
    // เข้ารหัสรหัสผ่านเพื่อความปลอดภัย (ไม่เก็บรหัสผ่านจริงลงฐานข้อมูล)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // จัดกลุ่มข้อมูลให้ตรงกับลำดับในคำสั่ง INSERT
    $data = [
        $email,
        $password,
        $_POST['prefix'],    // คำนำหน้า
        $_POST['firstname'], // ชื่อจริง
        $_POST['lastname'],  // นามสกุล
        $_POST['gender'],    // เพศ
        $_POST['birthdate'], // วันเกิด
        $_POST['province']   // จังหวัด
    ];

    // --- [3. ขั้นตอนการบันทึกลงฐานข้อมูล] ---
    try {
        // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูลผู้ใช้ใหม่
        $sql = "INSERT INTO users (email, password, prefix, firstname, lastname, gender, birthdate, province) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // ประมวลผลการบันทึกข้อมูล
        $stmt->execute($data);

        // ถ้าบันทึกสำเร็จ ให้แสดง Alert และส่งผู้ใช้ไปหน้า Login
        echo "<script>alert('สมัครสมาชิกเรียบร้อยแล้ว! เข้าสู่ระบบได้เลย'); window.location.href='/login';</script>";
        exit;

    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาดที่คาดไม่ถึง ให้ Alert แจ้งเตือนและย้อนกลับหน้าเดิม
        echo "<script>alert('เกิดข้อผิดพลาดบางอย่าง: " . $e->getMessage() . "'); window.history.back();</script>";
        exit;
    }
}

// ถ้าเป็นการเปิดหน้าเว็บปกติ (ไม่ได้ส่งฟอร์ม) ให้แสดงหน้าสมัครสมาชิก
renderView('register');