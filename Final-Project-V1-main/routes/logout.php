<?php
// routes/logout.php

// ล้างข้อมูล Session ทั้งหมด
session_destroy();

// เด้งกลับไปหน้า Login
header("Location: /login");
exit;
?>