<?php
// routes/edit_event.php

// 1. เช็คล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

// 2. เช็คว่ามี ID ส่งมามั้ย
if (!isset($_GET['id'])) {
    header("Location: /");
    exit;
}

$event_id = $_GET['id'];
$event = getEventById($event_id);

// 3. เช็คว่าเป็นเจ้าของกิจกรรมมั้ย (สำคัญมาก!)
if ($_SESSION['user_id'] != $event['user_id']) {
    echo "<script>alert('คุณไม่มีสิทธิ์แก้ไขกิจกรรมนี้!'); window.location.href='/';</script>";
    exit;
}

// 4. ถ้ามีการกดบันทึก (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['event_name'];
    $desc = $_POST['description'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $max = $_POST['max_attendees'];

    if (updateEvent($event_id, $name, $desc, $start, $end, $max)) {
        echo "<script>alert('แก้ไขเรียบร้อย!'); window.location.href='/';</script>";
        exit;
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด!');</script>";
    }
}

// ส่งข้อมูลเก่าไปโชว์ในฟอร์ม
renderView('edit_event', ['event' => $event]);
?>