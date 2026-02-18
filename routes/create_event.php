<?php
// routes/create_event.php

// เช็คก่อนว่าล็อกอินยัง? ถ้ายังไม่ล็อกอิน ห้ามสร้าง
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['event_name'];
    $desc = $_POST['description'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $max = $_POST['max_attendees'];

    // 1. สร้างกิจกรรมลง Database
    $event_id = createEvent($user_id, $name, $desc, $start, $end, $max);

    if ($event_id) {
        // 2. ถ้าสร้างสำเร็จ -> จัดการอัปโหลดรูป
        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == 0) {
            
            // ตั้งชื่อไฟล์ใหม่กันซ้ำ (เช่น event_1_timestamp.jpg)
            $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
            $new_name = "event_" . $event_id . "_" . time() . "." . $ext;
            $target = __DIR__ . "/../public/uploads/" . $new_name;

            // สร้างโฟลเดอร์ uploads ถ้ายังไม่มี
            if (!file_exists(__DIR__ . "/../public/uploads/")) {
                mkdir(__DIR__ . "/../public/uploads/", 0777, true);
            }

            // ย้ายไฟล์ไปเก็บ
            if (move_uploaded_file($_FILES['event_image']['tmp_name'], $target)) {
                // บันทึกชื่อรูปภาพลง Database
                addEventImage($event_id, $new_name);
            }
        }

        echo "<script>alert('สร้างกิจกรรมเรียบร้อย!'); window.location.href='/';</script>";
        exit;
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
    }
}

renderView('create_event');
?>