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

// ฟังก์ชันดึงรายชื่อคนเข้างาน (สำหรับเจ้าของงานดู)
function getParticipants($event_id) {
    $conn = getConnection();
    $sql = "SELECT r.*, u.firstname, u.lastname, u.email 
            FROM registrations r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}
?>