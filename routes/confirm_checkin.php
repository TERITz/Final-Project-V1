<?php
// routes/confirm_checkin.php
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

// รับค่า ID กิจกรรมและ ID ผู้ใช้จาก URL
$event_id = $_GET['event_id'] ?? null;
$user_id = $_GET['user_id'] ?? null;

if ($event_id && $user_id) {
    // เรียกใช้ฟังก์ชันอัปเดตสถานะ
    if (updateCheckInStatus($user_id, $event_id)) {
        // เมื่อสำเร็จ ให้กลับไปยังหน้ารายชื่อเดิมพร้อมแจ้งเตือนสำเร็จ
        header("Location: /attendeelist?id=" . $event_id . "&success=1");
        exit;
    }
}
echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
?>