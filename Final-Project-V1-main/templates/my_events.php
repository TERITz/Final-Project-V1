<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>กิจกรรมของฉัน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-6">กิจกรรมที่เข้าร่วม</h1>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-4">ชื่อกิจกรรม</th>
                        <th class="px-6 py-4">วันที่จัด</th>
                        <th class="px-6 py-4">สถานะ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php if ($data['my_list']->num_rows > 0): ?>
                        <?php while($row = $data['my_list']->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium"><?php echo htmlspecialchars($row['event_name']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo $row['start_date']; ?></td>
                            <td class="px-6 py-4">
                                <?php if($row['status'] == 'Pending'): ?>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">รอการอนุมัติ</span>
                                <?php elseif($row['status'] == 'Approved'): ?>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">อนุมัติแล้ว</span>
                                <?php else: ?>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">ไม่ผ่านการอนุมัติ</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic">คุณยังไม่ได้สมัครกิจกรรมใดๆ</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>