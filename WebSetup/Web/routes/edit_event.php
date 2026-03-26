<?php
// routes/edit_event.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: /");
    exit;
}

$event_id = $_GET['id'];
$event    = getEventById($event_id);

if ($_SESSION['user_id'] != $event['user_id']) {
    echo "<script>alert('คุณไม่มีสิทธิ์แก้ไขกิจกรรมนี้!'); window.location.href='/';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['event_name'];
    $desc  = $_POST['description'];
    $start = $_POST['start_date'];
    $end   = $_POST['end_date'];
    $max   = $_POST['max_attendees'];

    updateEvent($event_id, $name, $desc, $start, $end, $max);

    // อัปโหลดรูปใหม่ถ้ามี
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
            if ($_FILES['images']['error'][$index] === 0) {
                $ext      = pathinfo($_FILES['images']['name'][$index], PATHINFO_EXTENSION);
                $new_name = "event_" . $event_id . "_" . time() . "_" . $index . "." . $ext;
                $target   = __DIR__ . "/../public/uploads/" . $new_name;
                if (move_uploaded_file($tmp_name, $target)) {
                    addEventImage($event_id, $new_name);
                }
            }
        }
    }

    echo "<script>alert('แก้ไขเรียบร้อย!'); window.location.href='/';</script>";
    exit;
}

// ดึงรูปปัจจุบันส่งไป View
$imagesResult = getEventImages($event_id);
$images       = [];
while ($img = $imagesResult->fetch_assoc()) {
    $images[] = $img;
}

renderView('edit_event', [
    'event'  => $event,
    'images' => $images
]);
?>