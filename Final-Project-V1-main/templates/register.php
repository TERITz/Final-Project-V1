<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนสมาชิก</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-lg border border-gray-200 rounded-lg shadow-sm p-8 my-10">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">ลงทะเบียนสมาชิกใหม่</h1>
            <p class="text-sm text-gray-500 mt-1">กรอกข้อมูลให้ครบถ้วนเพื่อสร้างบัญชีของคุณ</p>
        </div>

        <form action="/register" method="POST" class="space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b border-gray-100 pb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">อีเมล</label>
                    <input type="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none placeholder-gray-400"
                        placeholder="example@mail.com">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">รหัสผ่าน</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none"
                        placeholder="รหัสผ่าน 1 ตัวขึ้นไป">
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label class="block text-gray-700 text-sm font-semibold mb-1">คำนำหน้า</label>
                        <select name="prefix" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none bg-white">
                            <option value="" disabled selected>คำนำหน้า</option>
                            <option value="นาย">นาย</option>
                            <option value="นางสาว">นางสาว</option>
                            <option value="นาง">นาง</option>
                        </select>
                    </div>
                    <div class="col-span-2 text-sm font-semibold text-gray-700">
                         <label class="block mb-1">เพศ</label>
                         <div class="flex items-center space-x-4 py-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="gender" value="ชาย" checked class="text-blue-500 focus:ring-blue-500">
                                <span class="ml-2 font-normal">ชาย</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="gender" value="หญิง" class="text-blue-500 focus:ring-blue-500">
                                <span class="ml-2 font-normal">หญิง</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="gender" value="ไม่ต้องการระบุ" class="text-blue-500 focus:ring-blue-500">
                                <span class="ml-2 font-normal">ไม่ต้องการระบุ</span>
                            </label>
                         </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">ชื่อจริง</label>
                        <input type="text" name="firstname" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none"
                            placeholder="สมชาย">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">นามสกุล</label>
                        <input type="text" name="lastname" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none"
                            placeholder="ใจดี">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">วันเกิด</label>
                        <input type="date" name="birthdate" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">จังหวัด</label>
                        <input type="text" name="province" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-blue-500 outline-none"
                            placeholder="กรอกชื่อจังหวัด">
                    </div>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-md transition duration-200 shadow-md mt-6">
                ยืนยันการสมัครสมาชิก
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-gray-600 text-sm">มีบัญชีแล้วใช่ไหม?</p>
            <a href="/login" class="text-blue-500 font-bold hover:text-blue-700 mt-2 inline-block border-b border-blue-500">
                เข้าสู่ระบบที่นี่
            </a>
        </div>
    </div>

</body>
</html>