<?php
// routes/attendeelist.php

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: /");
    exit;
}

$event_id = $_GET['id'];

// ดึง attendees แล้วคำนวณ OTP ของแต่ละคนใน route ก่อนส่งไป View
$result    = getattendeelist($event_id);
$attendees = [];
while ($row = $result->fetch_assoc()) {
    $row['otp'] = generateUserOTP($event_id, $row['email']);
    $attendees[] = $row;
}

renderView('attendeelist', [
    'attendeelist' => $attendees,
    'event_id'     => $event_id,
]);
?>