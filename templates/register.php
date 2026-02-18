<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนสมาชิก</title>
</head>
<body>
    <h1>ลงทะเบียนสมาชิกใหม่</h1>
    <form action="/register" method="POST">
        <div>
            <label>อีเมล:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>รหัสผ่าน:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>คำนำหน้า:</label>
            <select name="prefix">
                <option value="นาย">นาย</option>
                <option value="นางสาว">นางสาว</option>
                <option value="นาง">นาง</option>
            </select>
        </div>
        <div>
            <label>ชื่อจริง:</label>
            <input type="text" name="firstname" required>
        </div>
        <div>
            <label>นามสกุล:</label>
            <input type="text" name="lastname" required>
        </div>
        <div>
            <label>เพศ:</label>
            <input type="radio" name="gender" value="ชาย" checked> ชาย
            <input type="radio" name="gender" value="หญิง"> หญิง
        </div>
        <div>
            <label>วันเกิด:</label>
            <input type="date" name="birthdate" required>
        </div>
        <div>
            <label>จังหวัด:</label>
            <input type="text" name="province" required>
        </div>
        <br>
        <button type="submit">ยืนยันการสมัคร</button>
    </form>
    <p>มีบัญชีแล้ว? <a href="/login">เข้าสู่ระบบ</a></p>
</body>
</html>