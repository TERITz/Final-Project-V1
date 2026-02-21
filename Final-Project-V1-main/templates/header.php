<!DOCTYPE html>
<html lang="th">
<head><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-50">
    <nav class="bg-slate-900 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                
                <div class="flex items-center space-x-8">
                    <a href="/" class="flex items-center space-x-2 group">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center group-hover:bg-blue-400 transition">
                            <span class="text-white text-lg">E</span>
                        </div>
                        <span class="text-white font-bold text-xl tracking-wide">EVENKUB</span>
                    </a>
                    
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/" class="text-gray-300 hover:text-white px-4 py-2 rounded-md text-sm font-medium transition hover:bg-slate-800">
                            หน้าแรก
                        </a>
                        <a href="/create_event" class="text-emerald-400 hover:text-emerald-300 px-4 py-2 rounded-md text-sm font-medium transition hover:bg-slate-800 border border-emerald-900/50">
                            + สร้างกิจกรรม
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex flex-col text-right hidden sm:block">
                        <span class="text-gray-400 text-xs uppercase tracking-widest">ผู้ใช้งาน</span>
                        <span class="text-white text-sm font-medium leading-none">
                             <?php echo $_SESSION['firstname']; ?>
                        </span>
                    </div>
                    
                    <div class="h-8 w-px bg-slate-700 mx-2"></div>

                    <a href="/logout" class="bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white px-4 py-2 rounded-lg text-sm font-bold transition duration-200 border border-rose-500/20">
                        ออกจากระบบ
                    </a>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>