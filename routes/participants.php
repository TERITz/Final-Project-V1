<?php
// routes/participants.php

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: /");
    exit;
}

$event_id = $_GET['id'];

// ดึงข้อมูลรายชื่อ
$participants = getParticipants($event_id);

// ส่งไปหน้า View
renderView('participants', ['participants' => $participants]);
?>