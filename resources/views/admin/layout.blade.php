<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
</head>
</head>

<body class="bg-gray-100 font-sans">

    <!-- ✅ Top Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-md fixed w-full top-0 left-0 z-40">
        <div class="mx-auto px-4 py-4 flex justify-between items-center">
            <button id="menu-toggle" class="text-white text-2xl focus:outline-none md:hidden">☰</button>
            <a href="/admin"><h1 class="text-xl font-bold text-white tracking-wide">🎓 ระบบจัดการสายรหัส</h1></a>
        </div>
    </nav>

    <div class="flex">
        <!-- ✅ Sidebar -->
        <div id="sidebar"
            class="bg-gradient-to-b from-blue-700 to-indigo-800 text-white w-64 fixed top-0 left-0 h-screen pt-20 md:translate-x-0 -translate-x-full transition-transform duration-300 z-30 flex flex-col justify-between">

            <!-- ✅ เมนูด้านบน -->
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.juniors') }}"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-green-600 transition">
                    <span class="mr-3">👶</span> <span>จัดการน้องรหัส (ปี 1)</span>
                </a>
                <a href="{{ route('admin.seniors') }}"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-600 transition">
                    <span class="mr-3">👨‍🎓</span> <span>จัดการพี่รหัส (ปี 2)</span>
                </a>
                <a href="{{ route('admin.export.results') }}"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-purple-600 transition">
                    <span class="mr-3">📥</span> <span>Export ผลการสุ่ม</span>
                </a>
                <a href="{{ url('/') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-600 transition">
                    <span class="mr-3">🔙</span> <span>กลับหน้าสุ่มสายรหัส</span>
                </a>
            </div>

            <!-- ✅ ปุ่ม Logout ล่างสุด -->
            <div class="px-4 pb-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg flex items-center justify-center space-x-2 transition">
                        <span>🚪</span> <span>ออกจากระบบ</span>
                    </button>
                </form>
            </div>
        </div>


        <!-- ✅ Main Content -->
        <div class="flex-1 md:ml-64 mt-20 p-6">
            <h2 class="text-4xl font-bold text-blue-700 mb-8">@yield('head')</h2>
            @yield('content')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</body>

</html>