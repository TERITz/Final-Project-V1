<?php
// routes/my_events.php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id'];
// เรียกใช้ฟังก์ชันที่เราเพิ่งสร้างใน Model
$my_list = getMyRegistrations($user_id);

renderView('my_events', ['my_list' => $my_list]);