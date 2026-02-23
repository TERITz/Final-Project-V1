<?php
// routes/approve.php การ updata status ผู้ขอเข้าร่วม
global $conn;

// ลองพ่นค่าออกมาดูว่า PHP เห็นอะไร
// var_dump($_GET); die(); 

$id = $_GET['reg_id'] ?? 0;
$status = $_GET['status'] ?? '';

if ($id != 0 && $status != '') {
    $sql = "UPDATE registrations SET status = ? WHERE reg_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    } else {
        die("Error: " . $conn->error);
    }
} else {
    // ถ้ามันมาตกตรงนี้ แสดงว่า $_GET['id'] หรือ $_GET['status'] มันว่างครับ
    die("ข้อมูลไม่ครบ: id คือ '$id', status คือ '$status'");
}