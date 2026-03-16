<?php
// database/registrations.php

function joinEvent($user_id, $event_id) {
    $conn = getConnection();
    if (hasJoined($user_id, $event_id)) {
        return false;
    }
    $sql = "INSERT INTO registrations (user_id, event_id, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    return $stmt->execute();
}

function hasJoined($user_id, $event_id) {
    $conn = getConnection();
    $sql  = "SELECT * FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function updateRegistrationStatus($reg_id, $status) {
    $conn = getConnection();
    $sql  = "UPDATE registrations SET status = ? WHERE reg_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $reg_id);
    return $stmt->execute();
}

function getParticipants($event_id) {
    $conn = getConnection();
    $sql  = "SELECT r.*, u.firstname, u.lastname, u.email, u.gender, u.province, u.prefix, u.birthdate
             FROM registrations r 
             JOIN users u ON r.user_id = u.user_id 
             WHERE r.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getattendeelist($event_id) {
    $conn = getConnection();
    $sql  = "SELECT r.reg_id, r.reg_date, r.status, 
                u.user_id, u.email, u.firstname, u.lastname, 
                u.gender, u.province, u.prefix, u.birthdate
             FROM registrations r 
             JOIN users u ON r.user_id = u.user_id 
             WHERE r.event_id = ? 
             AND (r.status = 'Approved' OR r.status = 'checked-in')
             ORDER BY r.status DESC, r.reg_date ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getApprovedCount($event_id) {
    $conn   = getConnection();
    $sql    = "SELECT COUNT(*) as total FROM registrations 
               WHERE event_id = ? AND (status = 'Approved' OR status = 'checked-in')";
    $stmt   = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'] ?? 0;
}

function getRegistrationStatus($user_id, $event_id) {
    $conn = getConnection();
    $sql  = "SELECT status FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['status'];
    }
    return false;
}

function getMyRegistrations($user_id) {
    $conn = getConnection();
    $sql  = "SELECT r.*, e.event_name, e.start_date, e.end_date 
             FROM registrations r
             JOIN events e ON r.event_id = e.event_id
             WHERE r.user_id = ?
             ORDER BY r.reg_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

// ดึงสถิติการเข้าร่วมกิจกรรมของ user คนนี้
function getMyStats($user_id) {
    $conn = getConnection();
    $sql  = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'checked-in' THEN 1 ELSE 0 END) as checked_in,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending
             FROM registrations
             WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// หา user จาก OTP ที่กรอกมา (สำหรับเจ้าของงานใช้เช็คอิน)
function findUserByOTP($event_id, $otp_input) {
    $conn   = getConnection();
    $sql    = "SELECT r.user_id, r.reg_id, u.email, u.firstname, u.lastname
               FROM registrations r
               JOIN users u ON r.user_id = u.user_id
               WHERE r.event_id = ? AND r.status = 'Approved'";
    $stmt   = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $otp = generateUserOTP($event_id, $row['email']);
        if ($otp === $otp_input) {
            return $row;
        }
    }
    return null;
}
?>