<?php
// routes/join_event.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // เรียกใช้ฟังก์ชัน joinEvent ที่เพิ่งสร้าง
    if (joinEvent($user_id, $event_id)) {
        echo "<script>alert('ขอเข้าร่วมกิจกรรมสำเร็จ!'); window.location.href='/';</script>";
    } else {
        echo "<script>alert('คุณได้ลงทะเบียนกิจกรรมนี้ไปแล้ว!'); window.location.href='/';</script>";
    }
} else {
    header("Location: /");
}
?>