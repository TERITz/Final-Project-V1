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

function getEvents($keyword = "", $start_date = "", $end_date = "") {
    $conn = getConnection();
    
    // ตั้งต้น SQL ด้วย WHERE 1=1 เพื่อให้ง่ายต่อการต่อ String ด้วย AND
   	$sql = "SELECT * FROM events WHERE 1=1 AND end_date >= NOW()";
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
//Hacking//
//สร้าง OTP จาก  event_id user_email เเละช่วงเวลา
function generateUserOTP($event_id, $user_email) {
    // 1. ทำความสะอาดข้อมูลอีเมลให้เป็นตัวพิมพ์เล็กและตัดช่องว่าง
    $clean_email = strtolower(trim($user_email));
    
    // 2. แบ่งช่วงเวลาเป็นบล็อกละ 30 นาที (1800 วินาที)
    $time_window = floor(time() / 1800); 

    // 3. สร้าง Seed ที่ประกอบด้วยรหัสกิจกรรม, อีเมลที่ทำความสะอาดแล้ว และช่วงเวลา
    $seed = "event_" . $event_id . "_" . $clean_email . "_" . $time_window;

    // 4. แปลง Hash เป็นตัวเลข 6 หลัก
    $hash = md5($seed);
    $otp = hexdec(substr($hash, -5)) % 1000000;
    
    return str_pad($otp, 6, '0', STR_PAD_LEFT);
}
//อัปเดต การเช็คอิน
function updateCheckInStatus($user_id, $event_id) {
    $conn = getConnection();
    // เปลี่ยนสถานะการสมัครให้เป็น 'checked-in' เพื่อยืนยันว่าเข้างานแล้ว
    $sql = "UPDATE registrations SET status = 'checked-in' 
            WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    return $stmt->execute();
}
//ดึง stats ต่างๆออกมา
function getEventStats($event_id) {
    $conn = getConnection();
    
    $sql = "SELECT 
                e.max_attendees,
                (SELECT COUNT(*) FROM registrations WHERE event_id = ?) as total_applied,
                (SELECT COUNT(*) FROM registrations WHERE event_id = ? AND (status = 'Approved' OR status = 'checked-in')) as total_approved,
                (SELECT COUNT(*) FROM registrations WHERE event_id = ? AND status = 'checked-in') as total_checked_in
            FROM events e 
            WHERE e.event_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $event_id, $event_id, $event_id, $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// ฟังก์ชันดึงรูปภาพทั้งหมดของกิจกรรม
function getEventImages($event_id) {
    $conn = getConnection();
    $sql = "SELECT image_path FROM event_images WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}
function isEventExpired($end_date) {
    date_default_timezone_set('Asia/Bangkok'); // ตั้งค่าเวลาให้เป็นไทย
    $end = new DateTime($end_date);
    $now = new DateTime();
    return $now > $end;
}
function get_myEvent($user_id){
    $conn = getConnection();
    // ดึงกิจกรรมที่ฉันเป็นเจ้าของ
    $sql = "SELECT * FROM events WHERE user_id = ? ORDER BY start_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

function DeleteEvent($event_id){
    $conn = getConnection();
    //ลบข้อมูลลูกในตาราง event_images ก่อน
    $sql_delete_images = "DELETE FROM event_images WHERE event_id = ?";
    $stmt_images = $conn->prepare($sql_delete_images);
    $stmt_images->bind_param("i", $event_id);
    $stmt_images->execute();
    $stmt_images->close();

    $sql_delete_registrations = "DELETE FROM registrations WHERE event_id = ?";
    $stmt_images = $conn->prepare($sql_delete_registrations);
    $stmt_images->bind_param("i", $event_id);
    $stmt_images->execute();
    $stmt_images->close();

    //เมื่อไม่มีลูกแล้ว จึงลบข้อมูลแม่ในตาราง events ได้
    $sql = "DELETE from events WHERE event_id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$event_id);
    $success = $stmt->execute();
    return $success;
}
?>