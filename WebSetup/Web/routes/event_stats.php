<?php
// routes/event_stats.php 

// 1. ตรวจสอบสิทธิ์และการล็อกอิน
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: /");
    exit;
}

$event_id = $_GET['id'];

// 2. ตรวจสอบสิทธิ์ว่าผู้ใช้คนนี้เป็นเจ้าของกิจกรรมจริงหรือไม่ (ป้องกันคนแอบดูสถิติ)
$event = getEventById($event_id);
if (!$event || $event['user_id'] != $_SESSION['user_id']) {
    header("Location: /"); // ถ้าไม่ใช่เจ้าของ ให้เด้งกลับหน้าหลัก
    exit;
}

// 3. ดึงข้อมูลสถิติจาก Database
// (ตรวจสอบให้แน่ใจว่าคุณเอาฟังก์ชัน getEventStats ไปใส่ใน database/events.php แล้ว)
$stats = getEventStats($event_id);

// 4. ส่งข้อมูลไปหน้า View (Template) โดยใช้ฟังก์ชัน renderView เหมือนไฟล์อื่นๆ
renderView('event_stats', [
    'stats'    => $stats,
    'event_id' => $event_id,
    'event'    => $event
]);
?>