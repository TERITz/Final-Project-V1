<?php
// routes/home.php

// เช็คล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

// รับคำค้นหา (ถ้ามี)
$keyword = isset($_GET['search']) ? $_GET['search'] : "";

// ดึงข้อมูลกิจกรรมมา
$events = getEvents($keyword);

// ส่งข้อมูลไปหน้าเว็บ
renderView('home', ['events' => $events, 'keyword' => $keyword]);
?>