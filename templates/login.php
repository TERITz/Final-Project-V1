<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-sm border border-gray-200 rounded-lg shadow-sm p-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">เข้าสู่ระบบ</h1>
            <p class="text-sm text-gray-500 mt-1">ใส่อีเมลและรหัสผ่านของคุณเพื่อเริ่มใช้งาน</p>
        </div>

        <form action="/login" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-1">อีเมลผู้ใช้งาน</label>
                <input type="email" name="email" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none placeholder-gray-400"
                    placeholder="name@mail.com">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-1">รหัสผ่าน</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none"
                    placeholder="กรอกรหัสผ่านของคุณ">
            </div>

            <button type="submit" 
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2.5 rounded-md transition duration-200 shadow-md">
                เข้าสู่ระบบ
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-gray-600 text-sm">ยังไม่มีบัญชีใช้งานใช่ไหม?</p>
            <a href="/register" class="text-blue-500 font-bold hover:text-blue-700 mt-2 inline-block border-b border-blue-500">
                สมัครสมาชิกใหม่ที่นี่
            </a>
        </div>
    </div>

</body>
</html>