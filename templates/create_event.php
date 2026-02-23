<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สร้างกิจกรรมใหม่</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <?php include 'header.php' ?>

    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-800">สร้างกิจกรรมใหม่</h1>
            <p class="text-gray-500 mt-2">กรอกข้อมูลรายละเอียดกิจกรรมของคุณให้ครบถ้วนเพื่อให้ผู้อื่นเข้าร่วม</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <form action="/create_event" method="POST" enctype="multipart/form-data" class="space-y-6">
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">ชื่อกิจกรรม:</label>
                    <input type="text" name="event_name" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                        placeholder="ระบุชื่อกิจกรรมของคุณ">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">รายละเอียด:</label>
                    <textarea name="description" required rows="4"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                        placeholder="อธิบายกิจกรรมของคุณให้ดูน่าสนใจ..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">วันเริ่ม:</label>
                        <input type="datetime-local" name="start_date" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">วันจบ:</label>
                        <input type="datetime-local" name="end_date" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">จำนวนรับสูงสุด (คน):</label>
                        <input type="number" name="max_attendees" required min="1"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                            placeholder="เช่น 50">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">รูปภาพปกกิจกรรม:</label>
                        <input type="file" name="event_image" required accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-lg py-1.5 px-2">
                    </div>
                </div>

                <div class="flex items-center space-x-4 pt-4 border-t border-gray-100">
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition transform active:scale-95">
                        บันทึกกิจกรรม
                    </button>
                    <a href="/" 
                        class="text-gray-500 hover:text-gray-800 font-bold py-2.5 px-6 transition">
                        ยกเลิก
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>