<?php
// routes/Delete_event.php

// 1. เช็คล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

// 2. เช็คว่ามี ID ส่งมามั้ย
if ($_SERVER['REQUEST_METHOD'] !=='POST' ||!isset($_POST['id'])) {
    header("Location: /");
    exit;
}

$event_id = $_POST['id'];
$event = getEventById($event_id);

// ตรวจสอบว่ามีกิจกรรมนี้อยู่จริงหรือไม่
if (!$event) {
    header("Location: /");
    exit;
}

// 3. เช็คว่าเป็นเจ้าของกิจกรรมมั้ย
if ($_SESSION['user_id'] != $event['user_id']) {
    echo "<script>alert('คุณไม่มีสิทธิ์ลบกิจกรรมนี้!'); window.location.href='/';</script>";
    exit;
}

if (DeleteEvent($event_id)) {
    header("Location: /?status=deleted");
    exit;
} else{
    echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล'); window.location.href='/';</script>";
    exit;
}
?>