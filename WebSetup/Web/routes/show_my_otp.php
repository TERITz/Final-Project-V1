<?php
if (!isset($_SESSION['user_id'])) { 
    die("Error: กรุณา Login ก่อนเข้าหน้านี้"); 
}

$event_id = $_GET['id'] ?? null;
if (!$event_id) { header("Location: /"); exit; }

$user_id = $_SESSION['user_id'];
$user = getUserById($user_id); // ใช้ ID จาก Session ดึงข้อมูล
$event = getEventById($event_id);

if (!$user) { die("Error: ไม่พบข้อมูลผู้ใช้ในระบบ"); }
if (!$event) { die("Error: ไม่พบข้อมูลกิจกรรม"); }

renderView('show_my_otp', [
    'event_id' => $event_id,
    'event_name' => $event['event_name'],
    'user_email' => $user['email'] // ส่ง Email ของคนที่ Login อยู่ไป
]);