<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายชื่อผู้เข้าร่วม</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <?php include 'header.php' ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">รายชื่อผู้เข้าร่วมกิจกรรม</h1>
            <a href="/" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg transition font-bold">
                ← ย้อนกลับ
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white">
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">วันที่สมัคร</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">ชื่อ-นามสกุล</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">อีเมล</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">จังหวัด</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider text-center">สถานะ</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider text-center bg-indigo-800">รหัส OTP ที่ต้องแสดง</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider text-center">จัดการการเข้างาน</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php if (count($data['attendeelist']) > 0): ?>
                            <?php foreach ($data['attendeelist'] as $row): ?>
                            <tr class="hover:bg-gray-50 transition <?php echo ($row['status'] === 'checked-in') ? 'bg-green-50' : ''; ?>">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $row['reg_date']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    <?php echo $row['prefix'] . $row['firstname'] . " " . $row['lastname']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 underline">
                                    <?php echo $row['email']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $row['province']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php if ($row['status'] === 'checked-in'): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">เช็คอินแล้ว</span>
                                    <?php elseif ($row['status'] === 'Approved'): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">อนุมัติแล้ว</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">ปฏิเสธ</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-blue-600 text-xl">
                                    <?php echo $row['otp']; ?> </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php if ($row['status'] === 'checked-in'): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                            เช็คอินเรียบร้อย
                                        </span>
                                    <?php elseif ($row['status'] === 'Approved'): ?>
                                        <a href="/confirm_checkin?event_id=<?php echo $data['event_id']; ?>&user_id=<?php echo $row['user_id']; ?>" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-md inline-block"
                                        onclick="return confirm('ยืนยันว่ารหัส OTP ตรงกัน และต้องการเช็คอินคุณ <?php echo $row['firstname']; ?>?');">
                                        ✅ ยืนยันเข้างาน
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center text-gray-400 italic bg-gray-50">
                                    ยังไม่มีใครสมัครกิจกรรมนี้
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // ให้หน้านี้รีเฟรชตัวเองทุกๆ 5 นาที (300,000 ms) 
        // เพื่อให้รหัส OTP อัปเดตตามเวลาปัจจุบันอัตโนมัติ
        setTimeout(function(){
            window.location.reload();
        }, 300000);
    </script>
</body>
</html>