<?php
// database/registrations.php

// ฟังก์ชันขอเข้าร่วมกิจกรรม
function joinEvent($user_id, $event_id) {
    $conn = getConnection();
    
    // เช็คก่อนว่าเคยสมัครไปหรือยัง?
    if (hasJoined($user_id, $event_id)) {
        return false; // สมัครไปแล้ว
    }

    $sql = "INSERT INTO registrations (user_id, event_id, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    return $stmt->execute();
}

// ฟังก์ชันเช็คว่าคนนี้สมัครงานนี้ไปหรือยัง
function hasJoined($user_id, $event_id) {
    $conn = getConnection();
    $sql = "SELECT * FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// ==========================================
// Kenz
// ==========================================
// ฟังก์ชันดึงรายชื่อผู้ขอเข้าร่วม (สำหรับเจ้าของงานดู)
function getParticipants($event_id) {
    $conn = getConnection();
    $sql = "SELECT r.*, u.firstname, u.lastname, u.email ,/*Kenz เพิ่ม */ u.gender, u.province, u.prefix, u.birthdate
            FROM registrations r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}
//ฟังก์ชันดึงข้อมูลส่วนตัวผู้เข้าร่วม (สำหรับเจ้าของงานดู)
function getattendeelist($event_id) {
    $conn = getConnection();
    
    // ปรับเงื่อนไข WHERE ให้รับทั้ง Approved และ checked-in
    $sql = "SELECT 
                r.reg_id, r.reg_date, r.status, 
                u.user_id, u.email, u.firstname, u.lastname, 
                u.gender, u.province, u.prefix, u.birthdate
            FROM registrations r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.event_id = ? 
            AND (r.status = 'Approved' OR r.status = 'checked-in')
            ORDER BY r.status DESC, r.reg_date ASC"; // เรียงลำดับให้คนยังไม่เช็คอินอยู่บน หรือตามวันที่
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}
function getApprovedCount($event_id) {
    $conn = getConnection();
    // สำคัญ: ต้องนับทั้ง 2 สถานะ จำนวนคนสมัครถึงจะไม่ลดลงเมื่อเข้างาน
    $sql = "SELECT COUNT(*) as total FROM registrations 
            WHERE event_id = ? 
            AND (status = 'Approved' OR status = 'checked-in')";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    return $result['total'] ?? 0;
}
// ==========================================
// Kenz
// ==========================================


//ฟังก์ชันคืนค่า Status เอาไปใช้ใน home เเสดงให้ผู้ใช้รู้นะครับน้อง ว่าตัวเอง ได้รับการอนุมัติรึยังที่ขอไป
function getRegistrationStatus($user_id, $event_id) {
    global $conn;
    $sql = "SELECT status FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['status']; // คืนค่า 'Pending', 'Approved', ฯลฯ
    }
    return false; // ยังไม่เคยสมัคร
}
// ดึงรายการกิจกรรมที่ User คนนี้สมัครไว้ทั้งหมด
function getMyRegistrations($user_id) {
    $conn = getConnection();
    $sql = "SELECT r.*, e.event_name, e.start_date, e.end_date 
            FROM registrations r
            JOIN events e ON r.event_id = e.event_id
            WHERE r.user_id = ?
            ORDER BY r.reg_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}
?>

