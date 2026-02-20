<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลัก - รายการกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; color: white; }
        .btn-join { background-color: #007bff; }
        .btn-edit { background-color: #ffc107; color: black; }
        .search-box { margin-bottom: 20px; padding: 10px; background: #f8f9fa; }
    </style>
</head>
<body>

    <?php include 'header.php' ?>

    <h1>รายการกิจกรรม</h1>

    <div class="search-box">
        <form action="/" method="GET">
            <input type="text" name="search" placeholder="ค้นหากิจกรรม..." value="<?php echo htmlspecialchars($data['keyword']); ?>">
            <button type="submit">ค้นหา</button>
            <?php if($data['keyword']): ?>
                <a href="/">ล้างค่า</a>
            <?php endif; ?>
        </form>
    </div>

    <?php 
    // เช็คว่ามีข้อมูลมั้ย
    if ($data['events']->num_rows > 0): 
        while($row = $data['events']->fetch_assoc()): 
    ?>
        <div class="card">
            <h3><?php echo htmlspecialchars($row['event_name']); ?></h3>
            <p><b>รายละเอียด:</b> <?php echo htmlspecialchars($row['description']); ?></p>
            <p>
                <b>วันที่:</b> <?php echo $row['start_date']; ?> ถึง <?php echo $row['end_date']; ?> | 
                <b>รับจำนวน:</b> <?php echo $row['max_attendees']; ?> คน
            </p>
            
            <div style="margin-top: 10px;">
                <?php if($_SESSION['user_id'] == $row['user_id']): ?>
                    <a href="/edit_event?id=<?php echo $row['event_id']; ?>" class="btn btn-edit">แก้ไข</a>
                    <a href="/participants?id=<?php echo $row['event_id']; ?>" class="btn" style="background-color: purple;">ดูรายชื่อผู้ที่ขอเข้าร่วมกิจกรรม</a>
                    <a href="/attendeelist?id=<?php echo $row['event_id']; ?>" class="btn" style="background-color: green;">ดูรายชื่อผู้ที่ได้เข้าร่วมกิจกรรมแล้ว</a>
                
                <?php else: ?>
                    <?php 
                        // 1. ดึงสถานะปัจจุบันมาเก็บไว้ในตัวแปร
                        $regStatus = getRegistrationStatus($_SESSION['user_id'], $row['event_id']); 
                    ?>
                    <?php if (!$regStatus): ?>
                        <a href="/join_event?id=<?php echo $row['event_id']; ?>" 
                        class="btn btn-join" 
                        onclick="return confirm('ยืนยันที่จะเข้าร่วมกิจกรรมนี้?');">ขอเข้าร่วม</a>

                    <?php elseif ($regStatus === 'Approved'): ?>
                        <button class="btn" style="background-color: green; color: white; cursor: not-allowed;">✔️ เข้าร่วมกิจกรรมแล้ว</a>

                    <?php elseif ($regStatus === 'Pending'): ?>
                        <button class="btn" style="background-color: gray; cursor: not-allowed;" disabled>ลงทะเบียนเเล้ว</button>

                    <?php elseif ($regStatus === 'Rejected'): ?>
                        <button class="btn" style="background-color: #f44336; cursor: not-allowed;" disabled>❌ ไม่ผ่านการอนุมัติ</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php 
        endwhile; 
    else: 
    ?>
        <p>ไม่พบกิจกรรมที่คุณค้นหา</p>
    <?php endif; ?>

</body>
</html>