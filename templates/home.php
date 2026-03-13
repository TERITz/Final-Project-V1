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
            <form action="/" method="GET" class="flex flex-wrap items-end gap-4">

                <div class="flex-grow">
                    <label class="block text-sm font-medium text-gray-700 mb-1">ค้นหากิจกรรม</label>
                    <input type="text" name="search"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="ชื่อกิจกรรมหรือรายละเอียด..."
                        value="<?php echo htmlspecialchars($data['keyword'] ?? ''); ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ตั้งแต่วันที่</label>
                    <input type="date" name="start_date"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                        value="<?php echo htmlspecialchars($data['start_date'] ?? ''); ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ถึงวันที่</label>
                    <input type="date" name="end_date"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                        value="<?php echo htmlspecialchars($data['end_date'] ?? ''); ?>">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition">
                        ค้นหา
                    </button>

                    <?php if ($data['keyword'] || $data['start_date'] || $data['end_date']): ?>
                        <a href="/" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-bold transition">
                            ล้างค่า
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <?php
            if ($data['events']->num_rows > 0):
                while ($row = $data['events']->fetch_assoc()):

                    $approvedCount = getApprovedCount($row['event_id']);
                    $isFull = ($approvedCount >= $row['max_attendees']);

                    // ดึงรูปทั้งหมดของกิจกรรมนี้
                    $images = [];
                    $imgResult = getEventImages($row['event_id']);
                    while ($img = $imgResult->fetch_assoc()) {
                        $images[] = $img['image_path'];
                    }
            ?>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">

                        <?php if (!empty($images)): ?>
                            <div class="relative h-52 overflow-hidden bg-gray-100" data-carousel data-index="0">

                                <?php foreach ($images as $i => $imgPath): ?>
                                    <img src="/uploads/<?php echo htmlspecialchars($imgPath); ?>"
                                        class="carousel-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-700"
                                        style="opacity: <?php echo $i === 0 ? '1' : '0'; ?>">
                                <?php endforeach; ?>

                                <?php if (count($images) > 1): ?>
                                    <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1.5">
                                        <?php foreach ($images as $i => $_): ?>
                                            <span class="carousel-dot w-2 h-2 rounded-full transition-all duration-300 <?php echo $i === 0 ? 'bg-white scale-125' : 'bg-white/50'; ?>"></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        <?php endif; ?>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">
                                <?php echo htmlspecialchars($row['event_name']); ?>
                            </h3>

                            <p class="text-gray-600 mb-4">
                                <b class="text-gray-800">รายละเอียด:</b> <?php echo htmlspecialchars($row['description']); ?>
                            </p>

                            <p class="text-sm text-gray-500 mb-6 bg-blue-50 p-3 rounded-lg inline-block">
                                <b class="text-gray-700">วันที่:</b> <?php echo $row['start_date']; ?> ถึง <?php echo $row['end_date']; ?> |
                                <b class="text-gray-700">รับจำนวน:</b>
                                <span class="<?php echo $isFull ? 'text-red-600' : 'text-blue-600'; ?> font-bold">
                                    <?php echo $approvedCount; ?> / <?php echo $row['max_attendees']; ?>
                                </span> คน
                                <?php if ($isFull): ?>
                                    <span class="text-red-600 font-bold ml-1">(เต็มแล้ว)</span>
                                <?php endif; ?>
                            </p>

                            <div class="flex flex-wrap gap-2 mt-2">
                                <?php if ($_SESSION['user_id'] == $row['user_id']): ?>
                                    <a href="/edit_event?id=<?php echo $row['event_id']; ?>"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg text-sm font-bold transition">แก้ไข</a>
                                    <a href="/participants?id=<?php echo $row['event_id']; ?>"
                                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">ดูรายชื่อผู้ที่ขอเข้าร่วมกิจกรรม</a>
                                    <a href="/attendeelist?id=<?php echo $row['event_id']; ?>"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">ดูรายชื่อผู้ที่ได้เข้าร่วมกิจกรรมแล้ว</a>
                                    <a href="/event_stats?id=<?php echo $row['event_id']; ?>"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">📊 สถิติภาพรวม</a>
                                <?php else: ?>
                                    <?php $regStatus = getRegistrationStatus($_SESSION['user_id'], $row['event_id']); ?>

                                    <?php if (!$regStatus): ?>
                                        <?php if ($isFull): ?>
                                            <button class="bg-gray-400 text-white px-6 py-2 rounded-lg font-bold cursor-not-allowed" disabled>เต็มแล้ว</button>
                                        <?php else: ?>
                                            <a href="/join_event?id=<?php echo $row['event_id']; ?>"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition"
                                                onclick="return confirm('ยืนยันที่จะเข้าร่วมกิจกรรมนี้?');">ขอเข้าร่วม</a>
                                        <?php endif; ?>

                                    <?php elseif ($regStatus === 'Approved' || $regStatus === 'checked-in'): ?>
                                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold flex items-center cursor-not-allowed" disabled>
                                            ✔️ <?php echo ($regStatus === 'checked-in') ? 'เข้างานเรียบร้อยแล้ว' : 'ผ่านการอนุมัติแล้ว'; ?>
                                        </button>
                                        <?php if ($regStatus === 'Approved'): ?>
                                            <a href="/show_my_otp?id=<?php echo $row['event_id']; ?>"
                                                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-bold transition shadow-sm">
                                                🔑 ดูรหัส OTP
                                            </a>
                                        <?php endif; ?>

                                    <?php elseif ($regStatus === 'Pending'): ?>
                                        <button class="bg-gray-400 text-white px-4 py-2 rounded-lg font-bold cursor-not-allowed" disabled>ลงทะเบียนแล้ว</button>

                                    <?php elseif ($regStatus === 'Rejected'): ?>
                                        <button class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold cursor-not-allowed" disabled>❌ ไม่ผ่านการอนุมัติ</button>
                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
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

    <script>
        document.querySelectorAll('[data-carousel]').forEach(function(carousel) {
            var slides = carousel.querySelectorAll('.carousel-slide');
            var dots   = carousel.querySelectorAll('.carousel-dot');
            if (slides.length <= 1) return;

            setInterval(function() {
                var current = parseInt(carousel.dataset.index);
                var next    = (current + 1) % slides.length;

                slides[current].style.opacity = '0';
                slides[next].style.opacity    = '1';
                dots[current].classList.replace('bg-white',    'bg-white/50');
                dots[current].classList.replace('scale-125',   'scale-100');
                dots[next].classList.replace('bg-white/50', 'bg-white');
                dots[next].classList.add('scale-125');

                carousel.dataset.index = next;
            }, 3000);
        });
    </script>

</body>

</html>