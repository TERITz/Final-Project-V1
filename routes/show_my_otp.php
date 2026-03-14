<?php
// routes/show_my_otp.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$event_id = $_GET['id'] ?? null;
if (!$event_id) {
    header("Location: /");
    exit;
}

$user_id = $_SESSION['user_id'];
$user    = getUserById($user_id);
$event   = getEventById($event_id);

if (!$user)  { die("Error: ไม่พบข้อมูลผู้ใช้ในระบบ"); }
if (!$event) { die("Error: ไม่พบข้อมูลกิจกรรม"); }

// คำนวณ OTP และเวลาที่เหลือใน route ก่อนส่งไป View
$my_otp           = generateUserOTP($event_id, $user['email']);
$remaining_seconds = 1800 - (time() % 1800);

renderView('show_my_otp', [
    'event_id'          => $event_id,
    'event_name'        => $event['event_name'],
    'user_email'        => $user['email'],
    'my_otp'            => $my_otp,
    'remaining_seconds' => $remaining_seconds
]);
?>