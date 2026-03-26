<?php
// routes/login.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['firstname'] = $user['firstname'];
        header("Location: /");
        exit;
    } else {
        echo "<script>alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง');</script>";
    }
}

renderView('login');
?>