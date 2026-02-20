<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายชื่อผู้เข้าร่วม</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'header.php' ?>
    <h1>รายชื่อผู้เข้าร่วมกิจกรรม</h1>
    <hr>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>วันที่สมัคร</th>
                <th>คำนำหน้าชื่อ</th>
                <th>ชื่อ-นามสกุล</th>
                <th>วันเกิด</th>
                <th>อีเมล</th>
                <th>เพศ</th>
                <th>จังหวัด</th>
                <th>สถานะ</th>
                <?php //ทำต่อหน่อยเอา ข้อมูล User ทั้งหมดยกเว้น รหัส เเล้วก็เลขไอดีไม่ต้องเอามา เอามาเเค่คิดว่า มันเปิดเผยได้ ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['attendeelist']->num_rows > 0): ?>
                <?php while($row = $data['attendeelist']->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['reg_date']; ?></td>
                    <td><?php echo $row['prefix']; ?></td>
                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                    <td><?php echo $row['birthdate']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['province']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">ยังไม่มีใครสมัครกิจกรรมนี้</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>