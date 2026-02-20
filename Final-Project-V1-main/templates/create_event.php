<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สร้างกิจกรรมใหม่</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <h1>สร้างกิจกรรมใหม่</h1>
    <form action="/create_event" method="POST" enctype="multipart/form-data">
        <div>
            <label>ชื่อกิจกรรม:</label>
            <input type="text" name="event_name" required>
        </div>
        <div>
            <label>รายละเอียด:</label>
            <textarea name="description" required></textarea>
        </div>
        <div>
            <label>วันเริ่ม:</label>
            <input type="datetime-local" name="start_date" required>
        </div>
        <div>
            <label>วันจบ:</label>
            <input type="datetime-local" name="end_date" required>
        </div>
        <div>
            <label>จำนวนรับสูงสุด:</label>
            <input type="number" name="max_attendees" required>
        </div>
        <div>
            <label>รูปภาพปก:</label>
            <input type="file" name="event_image" required accept="image/*">
        </div>
        <br>
        <button type="submit">บันทึกกิจกรรม</button>
        <a href="/">ยกเลิก</a>
    </form>
</body>
</html>