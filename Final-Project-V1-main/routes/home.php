<?php
// routes/home.php

// 1. เช็คล็อกอิน: ถ้ายังไม่ได้ Login ให้เด้งไปหน้า Login ก่อน
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

// 2. รับค่าจาก Query String (ค่าที่ส่งมาจากฟอร์มค้นหาด้วย Method GET)
// ค้นหาจากชื่อกิจกรรมหรือรายละเอียด
$keyword = isset($_GET['search']) ? $_GET['search'] : "";
// ค้นหาจากวันที่เริ่มต้น
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : "";
// ค้นหาถึงวันที่สิ้นสุด
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : "";

// 3. เรียกใช้ฟังก์ชัน getEvents จาก database/event.php 
// โดยส่งพารามิเตอร์ไปทั้ง 3 ตัว (ชื่อ, วันเริ่ม, วันจบ) เพื่อใช้กรองข้อมูลใน SQL
$events = getEvents($keyword, $start_date, $end_date);

// 4. ส่งข้อมูลทั้งหมดไปยังหน้า View (templates/home.php)
// ต้องส่ง keyword และวันที่กลับไปด้วย เพื่อให้ในช่อง Input ยังมีค่าที่ผู้ใช้เคยกรอกค้างไว้
renderView('home', [
    'events' => $events, 
    'keyword' => $keyword,
    'start_date' => $start_date,
    'end_date' => $end_date
]);
?>