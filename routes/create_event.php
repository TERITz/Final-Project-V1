<?php
// routes/create_event.php

// เช็คว่าล็อคอินรึยัง
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
        if (!file_exists(__DIR__ . "/../public/uploads/")) {
            mkdir(__DIR__ . "/../public/uploads/", 0777, true);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
                if ($_FILES['images']['error'][$index] === 0) {
                    $ext = pathinfo($_FILES['images']['name'][$index], PATHINFO_EXTENSION);
                    $new_name = "event_" . $event_id . "_" . time() . "_" . $index . "." . $ext;
                    $target = __DIR__ . "/../public/uploads/" . $new_name;

                    if (move_uploaded_file($tmp_name, $target)) {
                        addEventImage($event_id, $new_name);
                    }
                }
            }
        }

        echo "<script>alert('สร้างกิจกรรมเรียบร้อย!'); window.location.href='/';</script>";
        exit;
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
    }
}

renderView('create_event');
