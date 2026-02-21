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
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">คำนำหน้าชื่อ</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">ชื่อ-นามสกุล</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">วันเกิด</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">อีเมล</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">เพศ</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider">จังหวัด</th>
                            <th class="px-6 py-4 text-sm font-bold uppercase tracking-wider text-center">สถานะ</th>
                            <?php //ทำต่อหน่อยเอา ข้อมูล User ทั้งหมดยกเว้น รหัส เเล้วก็เลขไอดีไม่ต้องเอามา เอามาเเค่คิดว่า มันเปิดเผยได้ ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php if ($data['attendeelist']->num_rows > 0): ?>
                            <?php while($row = $data['attendeelist']->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $row['reg_date']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <?php echo $row['prefix']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $row['birthdate']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 underline">
                                    <?php echo $row['email']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $row['gender']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $row['province']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php if ($row['status'] === 'Approved'): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">อนุมัติแล้ว</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">ปฏิเสธ</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="px-6 py-20 text-center text-gray-400 italic bg-gray-50">
                                    ยังไม่มีใครสมัครกิจกรรมนี้
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($data['attendeelist']->num_rows > 0): ?>
        <div class="mt-4 text-sm text-gray-500">
            พบรายชื่อผู้เข้าร่วมทั้งหมด <strong><?php echo $data['attendeelist']->num_rows; ?></strong> รายการ
        </div>
        <?php endif; ?>
    </div>
</body>
</html>