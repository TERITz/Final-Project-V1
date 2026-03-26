<?php
// routes/verify_otp.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['event_id']) || !isset($_POST['otp'])) {
    header("Location: /");
    exit;
}

$event_id  = $_POST['event_id'];
$otp_input = trim($_POST['otp']);

// หา user จาก OTP ที่กรอก
$user = findUserByOTP($event_id, $otp_input);

if ($user) {
    // OTP ตรง → เช็คอินเลย
    updateCheckInStatus($user['user_id'], $event_id);
    echo "<script>alert('✅ เช็คอินสำเร็จ! คุณ " . $user['firstname'] . " " . $user['lastname'] . "'); window.location.href='/attendeelist?id=" . $event_id . "';</script>";
} else {
    // OTP ไม่ตรง
    echo "<script>alert('❌ รหัส OTP ไม่ถูกต้อง หรือผู้ใช้นี้เช็คอินแล้ว'); window.location.href='/attendeelist?id=" . $event_id . "';</script>";
}
exit;
?>