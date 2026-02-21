<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลัก - รายการกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <?php include 'header.php' ?>

    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">รายการกิจกรรม</h1>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
            <form action="/" method="GET" class="flex flex-wrap gap-3">
                <input type="text" name="search" 
                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                    placeholder="ค้นหากิจกรรม..." 
                    value="<?php echo htmlspecialchars($data['keyword']); ?>">
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition">
                    ค้นหา
                </button>

                <?php if($data['keyword']): ?>
                    <a href="/" class="flex items-center text-red-500 hover:text-red-700 font-medium px-2">
                        ล้างค่า
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="space-y-6">
            <?php 
            // เช็คว่ามีข้อมูลมั้ย
            if ($data['events']->num_rows > 0): 
                while($row = $data['events']->fetch_assoc()): 
            ?>
                <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">
                        <?php echo htmlspecialchars($row['event_name']); ?>
                    </h3>
                    
                    <p class="text-gray-600 mb-4">
                        <b class="text-gray-800">รายละเอียด:</b> <?php echo htmlspecialchars($row['description']); ?>
                    </p>
                    
                    <p class="text-sm text-gray-500 mb-6 bg-blue-50 p-3 rounded-lg inline-block">
                        <b class="text-gray-700">วันที่:</b> <?php echo $row['start_date']; ?> ถึง <?php echo $row['end_date']; ?> | 
                        <b class="text-gray-700">รับจำนวน:</b> <span class="text-blue-600 font-bold"><?php echo $row['max_attendees']; ?></span> คน
                    </p>
                    
                    <div class="flex flex-wrap gap-2 mt-2">
                        <?php if($_SESSION['user_id'] == $row['user_id']): ?>
                            <a href="/edit_event?id=<?php echo $row['event_id']; ?>" 
                               class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg text-sm font-bold transition">
                                แก้ไข
                            </a>
                            <a href="/participants?id=<?php echo $row['event_id']; ?>" 
                               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                ดูรายชื่อผู้ที่ขอเข้าร่วมกิจกรรม
                            </a>
                            <a href="/attendeelist?id=<?php echo $row['event_id']; ?>" 
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                ดูรายชื่อผู้ที่ได้เข้าร่วมกิจกรรมแล้ว
                            </a>
                        
                        <?php else: ?>
                            <?php 
                                // 1. ดึงสถานะปัจจุบันมาเก็บไว้ในตัวแปร
                                $regStatus = getRegistrationStatus($_SESSION['user_id'], $row['event_id']); 
                            ?>

                            <?php if (!$regStatus): ?>
                                <a href="/join_event?id=<?php echo $row['event_id']; ?>" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition" 
                                   onclick="return confirm('ยืนยันที่จะเข้าร่วมกิจกรรมนี้?');">
                                   ขอเข้าร่วม
                                </a>

                            <?php elseif ($regStatus === 'Approved'): ?>
                                <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold flex items-center cursor-not-allowed" disabled>
                                    ✔️ เข้าร่วมกิจกรรมแล้ว
                                </button>

                            <?php elseif ($regStatus === 'Pending'): ?>
                                <button class="bg-gray-400 text-white px-4 py-2 rounded-lg font-bold cursor-not-allowed" disabled>
                                    ลงทะเบียนเเล้ว
                                </button>

                            <?php elseif ($regStatus === 'Rejected'): ?>
                                <button class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold cursor-not-allowed" disabled>
                                    ❌ ไม่ผ่านการอนุมัติ
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php 
                endwhile; 
            else: 
            ?>
                <div class="bg-white p-10 rounded-xl border border-dashed border-gray-300 text-center">
                    <p class="text-gray-500 text-lg italic">ไม่พบกิจกรรมที่คุณค้นหา</p>
                    <a href="/" class="text-blue-500 hover:underline mt-2 inline-block font-bold">กลับไปดูรายการทั้งหมด</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>