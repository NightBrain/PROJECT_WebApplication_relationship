@extends('admin.layout')
@section('head','📊 สถิติภาพรวม')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- การ์ดสถิติ -->
                <div class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-medium">น้องรหัสทั้งหมด</h3>
                    <p class="text-4xl font-bold mt-2" id="totalJuniors">-</p>
                </div>
                <div class="bg-gradient-to-r from-blue-400 to-blue-500 text-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-medium">พี่รหัสทั้งหมด</h3>
                    <p class="text-4xl font-bold mt-2" id="totalSeniors">-</p>
                </div>
                <div class="bg-gradient-to-r from-purple-400 to-purple-500 text-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-medium">รวมทั้งหมด</h3>
                    <p class="text-4xl font-bold mt-2" id="totalAll">-</p>
                </div>
            </div>

            <!-- กราฟ -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white p-6 rounded-xl shadow-lg grid justify-center content-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">จำนวน น้องรหัส vs พี่รหัส</h3>
                        <canvas id="barChart" class="h-48"></canvas>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg grid justify-center content-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">อัตราส่วน ปี 1 กับ ปี 2</h3>
                        <canvas id="pieChart" class="h-48"></canvas>
                    </div>
                </div>
            </div>

            <script>
        // ✅ Toggle Sidebar (มือถือ)
        const menuToggle = document.getElementById("menu-toggle");
        const sidebar = document.getElementById("sidebar");
        menuToggle.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
        });

        // ✅ ข้อมูลจาก Controller
        const totalJuniors = {{ $totalJuniors ?? 0 }};
        const totalSeniors = {{ $totalSeniors ?? 0 }};
        document.getElementById('totalJuniors').textContent = totalJuniors;
        document.getElementById('totalSeniors').textContent = totalSeniors;
        document.getElementById('totalAll').textContent = totalJuniors + totalSeniors;

        // ✅ Chart.js
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['ปี 1', 'ปี 2'],
                datasets: [{
                    label: 'จำนวนคน',
                    data: [totalJuniors, totalSeniors],
                    backgroundColor: ['#34d399', '#3b82f6']
                }]
            },
            options: { responsive: false, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['น้องรหัส (ปี 1)', 'พี่รหัส (ปี 2)'],
                datasets: [{
                    data: [totalJuniors, totalSeniors],
                    backgroundColor: ['#34d399', '#3b82f6']
                }]
            },
            options: { responsive: false, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });
    </script>
@endsection
