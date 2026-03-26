<?php
// ตรวจสอบว่าเป็นการส่งข้อมูลผ่านฟอร์ม (POST) หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['email', 'password', 'prefix', 'firstname', 'lastname', 'gender', 'birthdate', 'province'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            echo "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่องก่อนกดยืนยัน'); window.history.back();</script>";
            exit;
        }
    }

    // เช็คอีเมลซ้ำผ่าน
    if (getUserByEmail($_POST['email'])) {
        echo "<script>alert('อีเมลนี้ถูกใช้งานไปแล้วครับ'); window.history.back();</script>";
        exit;
    }

    // สร้าง user
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    createUser(
        $_POST['email'], $password, $_POST['prefix'],
        $_POST['firstname'], $_POST['lastname'], $_POST['gender'],
        $_POST['birthdate'], $_POST['province']
    );

    echo "<script>alert('สมัครสมาชิกเรียบร้อยแล้ว'); window.location.href='/login';</script>";
    exit;
}

renderView('register');
?>