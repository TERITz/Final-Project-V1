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

        <!-- กล่องกรอก OTP เพื่อเช็คอิน -->
        <div class="bg-white rounded-xl shadow-sm border border-indigo-200 p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-1">🔑 เช็คอินด้วย OTP</h2>
            <p class="text-sm text-gray-500 mb-4">ให้ผู้เข้าร่วมแสดง OTP จากโทรศัพท์ แล้วกรอกตรงนี้เลย</p>
            <form action="/verify_otp" method="POST" class="flex gap-3">
                <input type="hidden" name="event_id" value="<?php echo $data['event_id']; ?>">
                <input type="text" name="otp" maxlength="6" placeholder="กรอกรหัส OTP 6 หลัก" required
                    class="flex-1 px-4 py-2.5 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-xl font-bold tracking-widest text-center"
                    autofocus>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-lg transition">
                    ✅ ยืนยันเช็คอิน
                </button>
            </form>
        </div>

        <!-- ตารางรายชื่อ -->
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php if ($data['attendeelist']->num_rows > 0): ?>
                            <?php while($row = $data['attendeelist']->fetch_assoc()): ?>
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
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                            ✅ เช็คอินแล้ว
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            อนุมัติแล้ว รอเช็คอิน
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-gray-400 italic bg-gray-50">
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
        setTimeout(function(){ window.location.reload(); }, 300000);
    </script>
</body>
</html>