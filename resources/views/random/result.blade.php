<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ผลการสุ่มสายรหัส</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .spin { animation: spin 0.5s linear infinite; }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }

        @keyframes glow {
            0%, 100% { text-shadow: 0 0 15px #93c5fd, 0 0 30px #3b82f6; }
            50% { text-shadow: 0 0 25px #60a5fa, 0 0 50px #2563eb; }
        }
        .glow { animation: glow 1.5s ease-in-out infinite alternate; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-200 min-h-screen flex items-center justify-center font-sans">

    <div class="w-full h-full max-w-7xl bg-white p-12 rounded-3xl shadow-2xl border border-gray-200 text-center animate-fadeInUp">
        <h1 class="text-5xl font-extrabold text-blue-700 mb-10">🎉 ผลการสุ่มสายรหัส 🎉</h1>

        <!-- ✅ ลูกเต๋า + นับถอยหลัง -->
        <div id="diceSection" class="flex flex-col items-center justify-center">
            <div class="w-28 h-28 bg-blue-500 text-white rounded-2xl flex items-center justify-center text-6xl font-bold spin" id="dice">
                🎲
            </div>
            <p class="mt-5 text-4xl font-extrabold text-gray-700" id="countdown">3</p>
        </div>

        <!-- ✅ MATCH + น้อง/พี่รหัส -->
        <div id="matchSection" class="hidden mt-10 flex items-center justify-center gap-20 animate-fadeInUp flex-wrap">
            <!-- น้องรหัส -->
            <div class="text-center">
                <h2 class="font-bold text-3xl text-gray-700 mb-4">👶 น้องรหัส</h2>
                <img src="{{ asset($junior->photo) }}" alt="รูปน้องรหัส"
                    class="mx-auto w-48 h-48 object-cover rounded-full ring-8 ring-blue-300 shadow-xl mb-4" />
                <p class="text-gray-600 text-xl">รหัส: <span class="font-bold text-blue-600">{{ $junior->code }}</span></p>
                <p class="text-gray-600 text-xl">ชื่อ: <span class="font-bold">{{ $junior->name }}</span></p>
            </div>

            <!-- MATCH -->
            <div class="text-center">
                <h2 class="text-6xl font-extrabold text-blue-600 glow">💙 MATCH 💙</h2>
            </div>

            <!-- พี่รหัส -->
            <div class="text-center">
                <h2 class="font-bold text-3xl text-gray-700 mb-4">🧑‍🎓 พี่รหัส</h2>
                <img src="{{ asset($senior->photo) }}" alt="รูปพี่รหัส"
                    class="mx-auto w-48 h-48 object-cover rounded-full ring-8 ring-yellow-300 shadow-xl mb-4" />
                <p class="text-gray-600 text-xl">รหัส: <span class="font-bold text-blue-600">{{ $senior->code }}</span></p>
                <p class="text-gray-600 text-xl">ชื่อ: <span class="font-bold">{{ $senior->name }}</span></p>
            </div>
        </div>

        <!-- ✅ ปุ่มกลับ -->
        <div class="mt-12">
            <a href="{{ url('/') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-2xl font-semibold px-8 py-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                🔄 กลับหน้าสุ่ม
            </a>
        </div>
    </div>

    <script>
        let count = 5;
        const countdownEl = document.getElementById("countdown");
        const diceSection = document.getElementById("diceSection");
        const matchSection = document.getElementById("matchSection");

        const countdown = setInterval(() => {
            count--;
            countdownEl.textContent = count;
            if (count === 0) {
                clearInterval(countdown);
                diceSection.classList.add("hidden");
                matchSection.classList.remove("hidden");
                matchSection.classList.add("animate-fadeInUp");

                // ✅ พลุกระดาษ
                const duration = 2500;
                const end = Date.now() + duration;
                (function frame() {
                    confetti({
                        particleCount: 6,
                        spread: 120,
                        startVelocity: 40,
                        origin: { x: Math.random(), y: Math.random() - 0.2 }
                    });
                    if (Date.now() < end) {
                        requestAnimationFrame(frame);
                    }
                })();
            }
        }, 1000);
    </script>
</body>
</html>
