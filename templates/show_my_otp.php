<?php
// คำนวณรหัส OTP โดยใช้ Email ของนักศึกษาคนนี้
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
        <?php include 'header.php' ?>
        <div class="max-w-md mx-auto mt-10 p-8 bg-white rounded-3xl shadow-2xl border border-gray-100 text-center">
        <div class="mb-6">
            <span class="bg-orange-100 text-orange-600 py-1 px-4 rounded-full text-sm font-bold uppercase tracking-wide">
                Your Entry Code
            </span>
        </div>
        
        <h2 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($data['event_name']); ?></h2>
        <p class="text-gray-500 text-sm mb-8">แสดงรหัสนี้ต่อผู้จัดงานเพื่อเข้างาน</p>

        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl py-10 mb-8">
            <span id="otp-code" class="text-6xl font-black text-blue-600 tracking-tighter">
                <?php echo $data["my_otp"]; ?>
            </span>
        </div>

        <div class="text-sm text-gray-400">
            รหัสจะเปลี่ยนใหม่ในอีก: <span id="timer" class="font-bold text-gray-600">--:--</span>
        </div>

        <div class="mt-8">
            <a href="/" class="text-blue-500 hover:text-blue-700 font-bold">← กลับหน้าหลัก</a>
        </div>
    </div>

    <script>
        let seconds = <?php echo $data["remaining_seconds"]; ?>;
        function updateTimer() {
            let mins = Math.floor(seconds / 60);
            let secs = seconds % 60;
            document.getElementById('timer').textContent = mins + ":" + (secs < 10 ? "0" : "") + secs;
            if (seconds <= 0) location.reload();
            seconds--;
        }
        setInterval(updateTimer, 1000);
        updateTimer();
    </script>
</body>
</html>
