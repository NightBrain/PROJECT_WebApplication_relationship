@extends('admin.layout')
@section('head', '👶 จัดการน้องรหัส (ปี 1) 🎓')
@section('content')

    <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-200">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-8 shadow-md" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                        </svg></div>
                    <div>
                        <p class="font-bold">สำเร็จ!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-xl shadow-lg mb-8 border border-blue-200">
            <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center">➕ เพิ่มน้องรหัสใหม่</h2>
            <form action="{{ route('admin.juniors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">รหัสน้องรหัส</label>
                        <input type="text" name="code" required
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150 ease-in-out"
                            placeholder="เช่น 66XXXXX" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อน้องรหัส</label>
                        <input type="text" name="name" required
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150 ease-in-out"
                            placeholder="ชื่อ-นามสกุล" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">รูป (ถ้ามี)</label>
                        <input type="file" name="photo"
                            class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150 ease-in-out" />
                    </div>
                </div>
                <button type="submit"
                    class="mt-8 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    ➕ เพิ่มน้องรหัส
                </button>
            </form>
        </div>

        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-8 rounded-xl shadow-lg mb-8 border border-green-200">
            <h2 class="text-2xl font-bold text-green-700 mb-6 flex items-center">📥 Import CSV</h2>
            <form action="{{ route('admin.juniors.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <input type="file" name="file" required
                        class="w-full sm:w-auto text-gray-700 bg-white border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 ease-in-out" />
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 w-full sm:w-auto">
                        🚀 Import
                    </button>
                </div>
            </form>
        </div>

        <a href="{{ route('admin.export.results') }}"
            class="inline-block mb-8 bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            📊 Export สรุปผล (Excel)
        </a>

        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">📋 ข้อมูลน้องรหัส</h2>
            <div class="overflow-x-auto">
                <table id="juniorTable" class="w-full border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <tr>
                            <th class="p-4 text-center font-semibold">SID</th>
                            <th class="p-4 text-center font-semibold">Name</th>
                            <th class="p-4 text-center font-semibold">Image</th>
                            <th class="p-4 text-center font-semibold">Se->STU</th>
                            <th class="p-4 text-center font-semibold">Manager</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($juniors as $junior)
                            <tr class="hover:bg-blue-50 border-b border-gray-100 transition duration-150 ease-in-out">
                                <td class="p-4 text-gray-800">{{ $junior->code }}</td>
                                <td class="p-4 text-gray-800">{{ $junior->name }}</td>
                                <td class="p-4 text-center">
                                    @if($junior->photo)
                                        <img src="{{ asset($junior->photo) }}"
                                            class="w-16 h-16 object-cover rounded-full mx-auto ring-2 ring-blue-300 p-0.5"
                                            alt="Junior Photo" />
                                    @else
                                        <span class="text-gray-400 text-2xl">👤</span>
                                    @endif
                                </td>
                                <td class="p-4 text-gray-800">
                                    {{ $junior->senior ? $junior->senior->name . ' (' . $junior->senior->code . ')' : '-' }}
                                </td>
                                <td class="p-4 text-center space-x-3">
                                    <button onclick="editJunior('{{ $junior->id }}', '{{ $junior->name }}')"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                                        ✏️ แก้ไข
                                    </button>
                                    <button type="button" onclick="confirmDelete({{ $junior->id }})"
                                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        🗑️ ลบ
                                    </button>
                                    <form id="delete-form-{{ $junior->id }}"
                                        action="{{ route('admin.juniors.delete', $junior->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editJuniorModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50">
        <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl transform transition-all duration-300 scale-95 opacity-0"
            id="editJuniorModalContent">
            <h2 class="text-2xl font-bold mb-6 text-blue-700 text-center">✏️ แก้ไขน้องรหัส</h2>
            <form id="editJuniorForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="editJuniorName" class="block text-sm font-medium text-gray-700 mb-2">ชื่อน้องรหัส</label>
                    <input type="text" name="name" id="editJuniorName"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150 ease-in-out"
                        required />
                </div>
                <div class="mb-6">
                    <label for="editJuniorPhoto" class="block text-sm font-medium text-gray-700 mb-2">รูปใหม่
                        (ถ้ามี)</label>
                    <input type="file" name="photo" id="editJuniorPhoto"
                        class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150 ease-in-out" />
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">บันทึก</button>
                    <button type="button" onclick="closeJuniorModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#juniorTable').DataTable({
                "language": {
                    // โปรดตรวจสอบให้แน่ใจว่า URL นี้ถูกต้อง และไฟล์ th.json สามารถเข้าถึงได้
                    "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/th.json"
                },
                "pagingType": "full_numbers" // แสดงปุ่ม First, Previous, Next, Last
            });

            // Modal animations
            const editModal = document.getElementById('editJuniorModal');
            const editModalContent = document.getElementById('editJuniorModalContent');

            function showModal() {
                editModal.classList.remove('hidden');
                setTimeout(() => {
                    editModalContent.classList.remove('scale-95', 'opacity-0');
                    editModalContent.classList.add('scale-100', 'opacity-100');
                }, 50); // Small delay for transition
            }

            function hideModal() {
                editModalContent.classList.remove('scale-100', 'opacity-100');
                editModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    editModal.classList.add('hidden');
                }, 300); // Wait for transition to finish
            }

            window.editJunior = function (id, name) {
                document.getElementById('editJuniorName').value = name;
                document.getElementById('editJuniorForm').action = '/admin/juniors/update/' + id;
                showModal();
            };

            window.closeJuniorModal = function () {
                hideModal();
            };

            // Close modal when clicking outside content
            editModal.addEventListener('click', function (event) {
                if (event.target === editModal) {
                    hideModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !editModal.classList.contains('hidden')) {
                    hideModal();
                }
            });

            // SweetAlert2 function for delete confirmation
            window.confirmDelete = function (juniorId) {
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "คุณจะไม่สามารถย้อนกลับการกระทำนี้ได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626', // Tailwind red-600
                    cancelButtonColor: '#6b7280', // Tailwind gray-500
                    confirmButtonText: '<span class="font-semibold">ใช่, ลบเลย!</span>',
                    cancelButtonText: '<span class="font-semibold">ยกเลิก</span>',
                    reverseButtons: true,
                    focusConfirm: false, // ไม้ให้ปุ่มยืนยัน autofocus ตอนเปิด
                    buttonsStyling: true, // คงสไตล์ของปุ่มที่เรากำหนดเอง
                    customClass: {
                        popup: 'rounded-xl shadow-lg border border-gray-200',
                        title: 'text-xl font-bold text-gray-800 py-4',
                        htmlContainer: 'text-gray-700 leading-relaxed py-2',
                        icon: 'text-yellow-500 text-4xl my-4',
                        confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 mr-2',
                        cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 ml-2',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + juniorId).submit();
                    }
                });
            };
        });
    </script>
@endsection