<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายชื่อผู้เข้าร่วม</title>
</head>
<body>
    <h1>รายชื่อผู้ขอเข้าร่วมกิจกรรม</h1>
    <a href="/">back กลับหน้าหลัก</a>
    <hr>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>วันที่สมัคร</th>
                <th>ชื่อ-นามสกุล</th>
                <th>อีเมล</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['participants']->num_rows > 0): ?>
                <?php while($row = $data['participants']->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['reg_date']; ?></td>
                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">ยังไม่มีใครสมัครกิจกรรมนี้</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>