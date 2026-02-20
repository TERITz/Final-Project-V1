<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <h1>แก้ไขกิจกรรม</h1>
    
    <form action="/edit_event?id=<?php echo $data['event']['event_id']; ?>" method="POST">
        <div>
            <label>ชื่อกิจกรรม:</label>
            <input type="text" name="event_name" value="<?php echo htmlspecialchars($data['event']['event_name']); ?>" required>
        </div>
        <div>
            <label>รายละเอียด:</label>
            <textarea name="description" required><?php echo htmlspecialchars($data['event']['description']); ?></textarea>
        </div>
        <div>
            <label>วันเริ่ม:</label>
            <input type="datetime-local" name="start_date" 
                   value="<?php echo date('Y-m-d\TH:i', strtotime($data['event']['start_date'])); ?>" required>
        </div>
        <div>
            <label>วันจบ:</label>
            <input type="datetime-local" name="end_date" 
                   value="<?php echo date('Y-m-d\TH:i', strtotime($data['event']['end_date'])); ?>" required>
        </div>
        <div>
            <label>จำนวนรับสูงสุด:</label>
            <input type="number" name="max_attendees" value="<?php echo $data['event']['max_attendees']; ?>" required>
        </div>
        <br>
        <button type="submit">บันทึกการแก้ไข</button>
        <a href="/">ยกเลิก</a>
    </form>
</body>
</html>