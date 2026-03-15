<?php
// routes/home.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$keyword    = isset($_GET['search'])     ? $_GET['search']     : "";
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : "";
$end_date   = isset($_GET['end_date'])   ? $_GET['end_date']   : "";

// ดึง events แล้ว enrich ข้อมูลทั้งหมดใน route ก่อนส่งไป View
$eventsResult = getEvents($keyword, $start_date, $end_date);
$events = [];

while ($row = $eventsResult->fetch_assoc()) {
    // นับคนที่อนุมัติแล้ว
    $row['approvedCount'] = getApprovedCount($row['event_id']);
    $row['isFull']        = ($row['approvedCount'] >= $row['max_attendees']);

    // ดึงสถานะการสมัครของ user คนนี้
    $row['regStatus'] = getRegistrationStatus($_SESSION['user_id'], $row['event_id']);

    // ดึงรูปภาพ
    $images = [];
    $imgResult = getEventImages($row['event_id']);
    while ($img = $imgResult->fetch_assoc()) {
        $images[] = $img['image_path'];
    }
    $row['images'] = $images;

    $events[] = $row;
}

renderView('home', [
    'events'     => $events,
    'keyword'    => $keyword,
    'start_date' => $start_date,
    'end_date'   => $end_date
]);
?>