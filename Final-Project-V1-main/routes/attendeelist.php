<?php
// routes/attendeelist.php 

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: /");
    exit;
}

$event_id = $_GET['id'];

// ดึงข้อมูลรายชื่อผู้เข้าร่วม
$attendeelist = getattendeelist($event_id);

// ส่งไปหน้า View
renderView('attendeelist',['attendeelist' => $attendeelist]);
?>