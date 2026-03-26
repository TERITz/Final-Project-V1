<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการกิจกรรมของฉัน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include 'header.php'; ?>

    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">🛠️ การจัดการกิจกรรม</h1>
                <p class="text-gray-500 mt-1">รวบรวมกิจกรรมทั้งหมดที่คุณเป็นผู้สร้างและดูแล</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-900 text-white">
                    <tr>
                        <th class="px-6 py-4">ชื่อกิจกรรม</th>
                        <th class="px-6 py-4">วันที่จัด</th>
                        <th class="px-6 py-4 bg-blue-500">สถานะกิจกรรม</th>
                        <th class="px-6 py-4 text-right">เครื่องมือจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if ($data['my_created']->num_rows > 0): ?>
                        <?php while($row = $data['my_created']->fetch_assoc()): 
                            $isExpired = isEventExpired($row['end_date']);?>
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4 font-bold text-gray-800">
                                <?php echo htmlspecialchars($row['event_name']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php echo date('d/m/Y', strtotime($row['start_date'])); ?>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <?php if($isExpired): ?>
                                    <span class="text-red-600 bg-red-50 px-2 py-1 rounded-md font-medium"><b>หมดเวลากิจกรรม</b></span>
                                <?php else: ?>
                                    <span class="text-green-600 bg-green-50 px-2 py-1 rounded-md font-medium"><b>ดำเนินการอยู่</b></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="/participants?id=<?php echo $row['event_id']; ?>" class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-100">
                                        ผู้สมัครเข้างาน
                                    </a>
                                    <a href="/attendeelist?id=<?php echo $row['event_id']; ?>" class="bg-indigo-50 text-indigo-600 border border-indigo-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-100">
                                        หน้าเช็คอิน
                                    </a>
                                    <a href="/event_stats?id=<?php echo $row['event_id']; ?>" class="bg-slate-50 text-slate-600 border border-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-slate-100">
                                        สถิติ
                                    </a>
                                    <a href="/edit_event?id=<?php echo $row['event_id']; ?>" class="bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-amber-100">
                                        แก้ไข
                                    </a>
                                    <form action="/delete_event" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบกิจกรรมนี้?');" class="inline-block">
                                        <input type="hidden" name="id" value="<?php echo $row['event_id']; ?>">
    
                                        <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100">
                                            ลบกิจกรรม
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-20 text-center text-gray-400 italic bg-gray-50">
                                คุณยังไม่มีกิจกรรมที่สร้างเองในขณะนี้
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>