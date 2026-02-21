<?php
// database/events.php

function createEvent($user_id, $name, $desc, $start, $end, $max)
{
    $conn = getConnection();
    // 1. ลงข้อมูลกิจกรรม
    $sql = "INSERT INTO events (user_id, event_name, description, start_date, end_date, max_attendees) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $user_id, $name, $desc, $start, $end, $max);
    
    if ($stmt->execute()) {
        // คืนค่า ID ของกิจกรรมที่เพิ่งสร้าง (เอาไปใช้ต่อตอนลงรูป)
        return $stmt->insert_id;
    }
    return false;
}

function addEventImage($event_id, $image_path)
{
    $conn = getConnection();
    $sql = "INSERT INTO event_images (event_id, image_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $event_id, $image_path);
    return $stmt->execute();
}

function getAllEvents() {
    $conn = getConnection();
    // ดึงข้อมูลกิจกรรม + รูปภาพแรก (ถ้ามี)
    $sql = "SELECT e.*, u.firstname, u.lastname, 
            (SELECT image_path FROM event_images WHERE event_id = e.event_id LIMIT 1) as image_path
            FROM events e 
            JOIN users u ON e.user_id = u.user_id 
            ORDER BY e.event_id DESC";
    $result = $conn->query($sql);
    return $result; // ส่งคืนเป็น Object ผลลัพธ์ (เอาไป fetch ต่อหน้าเว็บ)
}

function getEvents($keyword = "") {
    $conn = getConnection();
    
    if ($keyword) {
        // ถ้ามีการค้นหา ให้หาจากชื่อ หรือ รายละเอียด
        $sql = "SELECT * FROM events WHERE event_name LIKE ? OR description LIKE ? ORDER BY event_id DESC";
        $stmt = $conn->prepare($sql);
        $term = "%" . $keyword . "%";
        $stmt->bind_param("ss", $term, $term);
    } else {
        // ถ้าไม่มีการค้นหา ให้ดึงมาทั้งหมด
        $sql = "SELECT * FROM events ORDER BY event_id DESC";
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->execute();
    return $stmt->get_result(); // ส่งผลลัพธ์กลับไปวนลูปหน้าเว็บ
}

// ดึงข้อมูลกิจกรรมตาม ID (เอาไว้เช็คเจ้าของ และเอาไปโชว์ในฟอร์ม)
function getEventById($id) {
    $conn = getConnection();
    $sql = "SELECT * FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// อัปเดตข้อมูลกิจกรรม
function updateEvent($id, $name, $desc, $start, $end, $max) {
    $conn = getConnection();
    $sql = "UPDATE events SET event_name=?, description=?, start_date=?, end_date=?, max_attendees=? WHERE event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $desc, $start, $end, $max, $id);
    return $stmt->execute();
}
?>