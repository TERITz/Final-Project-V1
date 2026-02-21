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

function getEvents($keyword = "", $start_date = "", $end_date = "") {
    $conn = getConnection();
    
    // ตั้งต้น SQL ด้วย WHERE 1=1 เพื่อให้ง่ายต่อการต่อ String ด้วย AND
    $sql = "SELECT * FROM events WHERE 1=1";
    $types = "";     // เก็บชนิดข้อมูลสำหรับ bind_param (เช่น sss)
    $params = [];    // เก็บค่าตัวแปรที่จะใช้ค้นหา
    
    // 1. ถ้ามีการพิมพ์ชื่อค้นหา (ค้นจากชื่อหรือรายละเอียด)
    if (!empty($keyword)) {
        $sql .= " AND (event_name LIKE ? OR description LIKE ?)";
        $term = "%" . $keyword . "%";
        $types .= "ss";
        $params[] = $term;
        $params[] = $term;
    }
    
    // 2. ถ้ามีการระบุ "วันเริ่มต้น"
    if (!empty($start_date)) {
        $sql .= " AND start_date >= ?";
        $types .= "s";
        $params[] = $start_date;
    }

    // 3. ถ้ามีการระบุ "วันสิ้นสุด"
    if (!empty($end_date)) {
        $sql .= " AND end_date <= ?";
        $types .= "s";
        $params[] = $end_date;
    }
    
    $sql .= " ORDER BY event_id DESC";
    $stmt = $conn->prepare($sql);
    
    // ถ้ามีเงื่อนไขการค้นหา ให้ทำการ bind_param โดยใช้ ... เพื่อกระจายค่าจาก Array
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt->get_result(); 
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