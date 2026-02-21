<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <?php include 'header.php' ?>

    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-800">แก้ไขกิจกรรม</h1>
            <p class="text-gray-500 mt-2">ปรับปรุงข้อมูลกิจกรรมของคุณให้เป็นปัจจุบัน</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <form action="/edit_event?id=<?php echo $data['event']['event_id']; ?>" method="POST" class="space-y-6">
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">ชื่อกิจกรรม:</label>
                    <input type="text" name="event_name" 
                        value="<?php echo htmlspecialchars($data['event']['event_name']); ?>" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">รายละเอียด:</label>
                    <textarea name="description" required rows="4"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm"><?php echo htmlspecialchars($data['event']['description']); ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">วันเริ่ม:</label>
                        <input type="datetime-local" name="start_date" 
                               value="<?php echo date('Y-m-d\TH:i', strtotime($data['event']['start_date'])); ?>" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">วันจบ:</label>
                        <input type="datetime-local" name="end_date" 
                               value="<?php echo date('Y-m-d\TH:i', strtotime($data['event']['end_date'])); ?>" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm">
                    </div>
                </div>

                <div class="md:w-1/2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">จำนวนรับสูงสุด (คน):</label>
                    <input type="number" name="max_attendees" 
                        value="<?php echo $data['event']['max_attendees']; ?>" required min="1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm">
                </div>

                <div class="flex items-center space-x-4 pt-6 border-t border-gray-100">
                    <button type="submit" 
                        class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition transform active:scale-95">
                        บันทึกการแก้ไข
                    </button>
                    <a href="/" 
                        class="text-gray-500 hover:text-gray-800 font-bold py-2.5 px-6 transition hover:underline">
                        ยกเลิก
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>