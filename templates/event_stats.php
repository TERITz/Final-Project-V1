<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สถิติกิจกรรม - <?php echo htmlspecialchars($event['event_name']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include 'header.php' ?>

    <?php
        // ดึงข้อมูลสถิติจาก database/events.php
        $stats = getEventStats($data['event_id']); 
        $event = getEventById($data['event_id']);
        
        // คำนวณเปอร์เซ็นต์การมางาน (Check-in Rate)
        $checkinRate = ($stats['total_approved'] > 0) 
            ? round(($stats['total_checked_in'] / $stats['total_approved']) * 100) 
            : 0;
    ?>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
                    📊 สถิติกิจกรรม: <?php echo htmlspecialchars($event['event_name']); ?>
                </h1>
                <p class="text-gray-500 mt-1">สรุปข้อมูลผู้เข้าร่วมและการเช็คอิน</p>
            </div>
            <a href="/" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                ← กลับหน้าหลัก
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">ผู้สมัครทั้งหมด</p>
                <p class="text-3xl font-black text-gray-800"><?php echo number_format($stats['total_applied']); ?></p>
                <p class="text-xs text-gray-400 mt-2">จำนวนคนกดสมัครส่งคำขอ</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">ได้รับอนุมัติแล้ว</p>
                <p class="text-3xl font-black text-gray-800">
                    <?php echo $stats['total_approved']; ?> <span class="text-lg text-gray-400">/ <?php echo $stats['max_attendees']; ?></span>
                </p>
                <p class="text-xs text-gray-400 mt-2">จากจำนวนที่รับสมัครทั้งหมด</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">มาเช็คอินที่งาน</p>
                <p class="text-3xl font-black text-gray-800"><?php echo number_format($stats['total_checked_in']); ?></p>
                <p class="text-xs text-gray-400 mt-2">สแกน OTP เข้างานเรียบร้อย</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs font-bold text-orange-600 uppercase tracking-wider mb-1">อัตราการเข้างาน</p>
                <p class="text-3xl font-black text-gray-800"><?php echo $checkinRate; ?>%</p>
                <p class="text-xs text-gray-400 mt-2">เทียบสัดส่วนคนมากับคนได้รับสิทธิ์</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">ความคืบหน้าการเช็คอินหน้างาน</h3>
                <span class="text-blue-600 font-bold"><?php echo $stats['total_checked_in']; ?> / <?php echo $stats['total_approved']; ?> คน</span>
            </div>
            
            <div class="w-full bg-gray-100 rounded-full h-5 relative overflow-hidden">
                <div class="bg-blue-600 h-full rounded-full transition-all duration-700 ease-out shadow-inner" 
                     style="width: <?php echo $checkinRate; ?>%">
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-blue-600 rounded-full"></span>
                    <span>เช็คอินเข้างานแล้ว (<?php echo $checkinRate; ?>%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-gray-200 rounded-full"></span>
                    <span>อนุมัติแล้วแต่ยังไม่มา (<?php echo 100 - $checkinRate; ?>%)</span>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="/attendeelist?id=<?php echo $data['event_id']; ?>" 
               class="text-blue-600 hover:text-blue-800 font-bold text-sm underline decoration-2 underline-offset-4">
               ดูรายชื่อผู้เข้าร่วมกิจกรรมทั้งหมดอย่างละเอียด →
            </a>
        </div>
    </div>
</body>
</html>