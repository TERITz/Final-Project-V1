<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>คำขอเข้าร่วม</title>
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
                <th>การอนุมัติ/ปฏิเสธ</th>
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
                    <td>
                        <?php if ($row['status'] === 'Pending'): ?>
                            <a href="/approve?reg_id=<?php echo $row['reg_id']; ?>&status=Approved">
                                <button type="button" style="color: green;">ยอมรับ</button>
                            </a>
                            ||
                            <a href="/approve?reg_id=<?php echo $row['reg_id']; ?>&status=Rejected">
                                <button type="button" style="color: red;">ปฏิเสธ</button>
                            </a>
                        <?php else: ?>
                            <span style="color: gray;">ดำเนินการแล้ว</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">ยังไม่มีใครสมัครกิจกรรมนี้</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>