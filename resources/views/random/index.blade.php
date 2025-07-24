<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>สุ่มสายรหัส</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ✅ พื้นหลัง Gradient เคลื่อนไหว */
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-bg {
            background: linear-gradient(-45deg, #93c5fd, #bfdbfe, #f0f9ff, #c7d2fe);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
        }

        /* ✅ วงกลมลอยพื้นหลัง */
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.4;
            animation: float 6s ease-in-out infinite alternate;
        }
        .circle1 { width: 180px; height: 180px; background: #93c5fd; top: 8%; left: 12%; animation-delay: 0s; }
        .circle2 { width: 130px; height: 130px; background: #c7d2fe; top: 72%; left: 58%; animation-delay: 2s; }
        .circle3 { width: 150px; height: 150px; background: #bfdbfe; top: 42%; left: 82%; animation-delay: 4s; }

        @keyframes float {
            from { transform: translateY(0px); }
            to { transform: translateY(-30px); }
        }

        /* ✅ Fade-in + slide-up กล่องฟอร์ม */
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
    </style>
</head>
<body class="animated-bg min-h-screen flex items-center justify-center relative overflow-hidden font-sans">

    <!-- ✅ วงกลมลอย -->
    <div class="floating-circle circle1"></div>
    <div class="floating-circle circle2"></div>
    <div class="floating-circle circle3"></div>

    <!-- ✅ กล่องฟอร์ม (ใหญ่ขึ้น) -->
    <div class="w-full max-w-3xl bg-white p-12 rounded-3xl shadow-2xl border border-gray-200 animate-fadeInUp relative z-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-blue-700 mb-2">สุ่มสายรหัส</h1>
            <p class="text-base text-gray-500">สำหรับนักศึกษาชั้นปีที่ 1 เท่านั้น</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5 text-sm animate-pulse">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('random') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                    รหัสนักศึกษา
                </label>
                <input
                    type="text"
                    name="code"
                    id="code"
                    required
                    placeholder="เช่น 673000101"
                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-300 text-lg focus:scale-[1.02]"
                />
                @error('code')
                    <p class="text-red-500 text-sm mt-2 animate-bounce">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-lg font-bold py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:translate-y-[-2px] active:translate-y-[1px]"
            >
                🎲 สุ่มสายรหัส
            </button>
        </form>
    </div>

</body>
</html>
