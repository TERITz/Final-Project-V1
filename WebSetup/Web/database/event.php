<?php
// database/event.php

function createEvent($user_id, $name, $desc, $start, $end, $max)
{
    $conn = getConnection();
    $sql = "INSERT INTO events (user_id, event_name, description, start_date, end_date, max_attendees) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $user_id, $name, $desc, $start, $end, $max);
    if ($stmt->execute()) {
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

// ลบรูปภาพตาม image_id
function deleteEventImage($image_id)
{
    $conn = getConnection();
    // ดึง path ก่อนลบ เพื่อเอาไปลบไฟล์จริงด้วย
    $sql = "SELECT image_path FROM event_images WHERE image_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row) {
        // ลบออกจาก DB
        $sql2 = "DELETE FROM event_images WHERE image_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $image_id);
        $stmt2->execute();
        // คืน path เพื่อให้ route ลบไฟล์จริง
        return $row['image_path'];
    }
    return false;
}

function getEvents($keyword = "", $start_date = "", $end_date = "") {
    $conn = getConnection();
    $sql    = "SELECT * FROM events WHERE 1=1 AND end_date >= NOW()";
    $types  = "";
    $params = [];

    if (!empty($keyword)) {
        $sql .= " AND (event_name LIKE ? OR description LIKE ?)";
        $term = "%" . $keyword . "%";
        $types .= "ss";
        $params[] = $term;
        $params[] = $term;
    }
    if (!empty($start_date)) {
        $sql .= " AND start_date >= ?";
        $types .= "s";
        $params[] = $start_date;
    }
    if (!empty($end_date)) {
        $sql .= " AND end_date <= ?";
        $types .= "s";
        $params[] = $end_date;
    }

    $sql .= " ORDER BY event_id DESC";
    $stmt = $conn->prepare($sql);
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

function getEventById($id) {
    $conn = getConnection();
    $sql  = "SELECT * FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateEvent($id, $name, $desc, $start, $end, $max) {
    $conn = getConnection();
    $sql  = "UPDATE events SET event_name=?, description=?, start_date=?, end_date=?, max_attendees=? WHERE event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $desc, $start, $end, $max, $id);
    return $stmt->execute();
}

// สร้าง OTP จาก event_id, user_email และช่วงเวลา (offset +7 ชั่วโมง)
function generateUserOTP($event_id, $user_email) {
    $clean_email = strtolower(trim($user_email));
    $thai_time   = time() + (7 * 3600);
    $time_window = floor($thai_time / 1800);
    $seed        = "event_" . $event_id . "_" . $clean_email . "_" . $time_window;
    $hash        = md5($seed);
    $otp         = hexdec(substr($hash, -5)) % 1000000;
    return str_pad($otp, 6, '0', STR_PAD_LEFT);
}

function updateCheckInStatus($user_id, $event_id) {
    $conn = getConnection();
    $sql  = "UPDATE registrations SET status = 'checked-in' WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    return $stmt->execute();
}

function getEventStats($event_id) {
    $conn = getConnection();
    $sql  = "SELECT 
                e.max_attendees,
                (SELECT COUNT(*) FROM registrations WHERE event_id = ?) as total_applied,
                (SELECT COUNT(*) FROM registrations WHERE event_id = ? AND (status = 'Approved' OR status = 'checked-in')) as total_approved,
                (SELECT COUNT(*) FROM registrations WHERE event_id = ? AND status = 'checked-in') as total_checked_in
             FROM events e WHERE e.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $event_id, $event_id, $event_id, $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// ดึงรูปภาพทั้งหมด พร้อม image_id เพื่อให้ลบได้
function getEventImages($event_id) {
    $conn = getConnection();
    $sql  = "SELECT image_id, image_path FROM event_images WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}

function isEventExpired($end_date) {
    $end = new DateTime($end_date);
    $now = new DateTime();
    return $now > $end;
}

function get_myEvent($user_id) {
    $conn = getConnection();
    $sql  = "SELECT * FROM events WHERE user_id = ? ORDER BY start_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

function DeleteEvent($event_id) {
    $conn = getConnection();

    $sql  = "DELETE FROM event_images WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();

    $sql  = "DELETE FROM registrations WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();

    $sql  = "DELETE FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    return $stmt->execute();
}
?>