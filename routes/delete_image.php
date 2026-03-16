<?php
// routes/delete_image.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['image_id']) || !isset($_POST['event_id'])) {
    header("Location: /");
    exit;
}

$image_id = $_POST['image_id'];
$event_id = $_POST['event_id'];

// เช็คว่าเป็นเจ้าของกิจกรรมมั้ย
$event = getEventById($event_id);
if (!$event || $event['user_id'] != $_SESSION['user_id']) {
    echo "<script>alert('คุณไม่มีสิทธิ์ลบรูปนี้!'); window.location.href='/';</script>";
    exit;
}

// ลบจาก DB และได้ path กลับมา
$image_path = deleteEventImage($image_id);

if ($image_path) {
    // ลบไฟล์จริงออกจาก server ด้วย
    $file_path = __DIR__ . "/../public/uploads/" . $image_path;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

header("Location: /edit_event?id=" . $event_id);
exit;
?>