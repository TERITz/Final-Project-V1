<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
</head>
<body>
    <h1>เข้าสู่ระบบ</h1>
    <form action="/login" method="POST">
        <div>
            <label>อีเมล:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>รหัสผ่าน:</label>
            <input type="password" name="password" required>
        </div>
        <br>
        <button type="submit">Login</button>
    </form>
    <p>ยังไม่มีบัญชี? <a href="/register">สมัครสมาชิก</a></p>
</body>
</html>