@extends('admin.layout')
@section('head', '🧑‍🎓 จัดการพี่รหัส (ปี 2) ✨')
@section('content')

<div class="bg-white p-8 rounded-3xl shadow-xl border border-purple-200">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-8 shadow-md" role="alert">
            <div class="flex items-center">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">สำเร็จ!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-8 rounded-xl shadow-lg mb-8 border border-purple-200">
        <h2 class="text-2xl font-bold text-purple-700 mb-6 flex items-center">➕ เพิ่มพี่รหัสใหม่</h2>
        <form action="{{ route('admin.seniors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">รหัสพี่รหัส</label>
                    <input type="text" name="code" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-purple-500 focus:border-purple-500 shadow-sm transition duration-150 ease-in-out" placeholder="เช่น 65XXXXX" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อพี่รหัส</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-purple-500 focus:border-purple-500 shadow-sm transition duration-150 ease-in-out" placeholder="ชื่อ-นามสกุล" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">จำนวนรับน้องสูงสุด</label>
                    <input type="number" name="max_juniors" min="1" value="1" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-purple-500 focus:border-purple-500 shadow-sm transition duration-150 ease-in-out" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">รูป (ถ้ามี)</label>
                    <input type="file" name="photo" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 shadow-sm transition duration-150 ease-in-out" />
                </div>
            </div>
            <button type="submit" class="mt-8 bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                ➕ เพิ่มพี่รหัส
            </button>
        </form>
    </div>

    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-8 rounded-xl shadow-lg mb-8 border border-green-200">
        <h2 class="text-2xl font-bold text-green-700 mb-6 flex items-center">📥 Import CSV</h2>
        <form action="{{ route('admin.seniors.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <input type="file" name="file" required class="w-full sm:w-auto text-gray-700 bg-white border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 ease-in-out" />
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 w-full sm:w-auto">
                    🚀 Import
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">📋 ข้อมูลพี่รหัส</h2>
        <div class="overflow-x-auto">
            <table id="seniorTable" class="w-full border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <thead class="bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                    <tr>
                        <th class="p-4 text-left font-semibold">รหัส</th>
                        <th class="p-4 text-left font-semibold">ชื่อ</th>
                        <th class="p-4 text-center font-semibold">รูป</th>
                        <th class="p-4 text-center font-semibold">จำนวนรับน้องสูงสุด</th>
                        <th class="p-4 text-center font-semibold">สถานะ</th>
                        <th class="p-4 text-center font-semibold">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seniors as $senior)
                    <tr class="hover:bg-purple-50 border-b border-gray-100 transition duration-150 ease-in-out">
                        <td class="p-4 text-gray-800">{{ $senior->code }}</td>
                        <td class="p-4 text-gray-800">{{ $senior->name }}</td>
                        <td class="p-4 text-center">
                            @if($senior->photo)
                                <img src="{{ asset($senior->photo) }}" alt="รูปพี่รหัส" class="w-16 h-16 object-cover rounded-full mx-auto ring-2 ring-purple-300 p-0.5" />
                            @else
                                <span class="text-gray-400 text-2xl">🧑‍🎓</span>
                            @endif
                        </td>
                        <td class="p-4 text-center text-gray-800">{{ $senior->max_juniors }}</td>
                        <td class="p-4 text-center">
                            @php
                                $statusClass = '';
                                if ($senior->status == 'open') {
                                    $statusClass = 'bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold';
                                } elseif ($senior->status == 'closed') {
                                    $statusClass = 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold';
                                } elseif ($senior->status == 'full') {
                                    $statusClass = 'bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold';
                                }
                            @endphp
                            <span class="{{ $statusClass }}">{{ ucfirst($senior->status) }}</span>
                        </td>
                        <td class="p-4 text-center space-x-3">
                            <button onclick="editSenior('{{ $senior->id }}', '{{ $senior->name }}', '{{ $senior->max_juniors }}')" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                                ✏️ แก้ไข
                            </button>
                            <button type="button" onclick="confirmDelete({{ $senior->id }})" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                🗑️ ลบ
                            </button>
                            <form id="delete-form-{{ $senior->id }}" action="{{ route('admin.seniors.delete', $senior->id) }}" method="POST" style="display: none;">
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

<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="editModalContent">
        <h2 class="text-2xl font-bold mb-6 text-purple-700 text-center">✏️ แก้ไขพี่รหัส</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label for="editName" class="block text-sm font-medium text-gray-700 mb-2">ชื่อพี่รหัส</label>
                <input type="text" name="name" id="editName" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-purple-500 focus:border-purple-500 shadow-sm transition duration-150 ease-in-out" required />
            </div>
            <div class="mb-5">
                <label for="editMax" class="block text-sm font-medium text-gray-700 mb-2">จำนวนรับน้องสูงสุด</label>
                <input type="number" name="max_juniors" id="editMax" min="1" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-purple-500 focus:border-purple-500 shadow-sm transition duration-150 ease-in-out" required />
            </div>
            <div class="mb-6">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700 mb-2">รูปใหม่ (ถ้ามี)</label>
                <input type="file" name="photo" id="editPhoto" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 shadow-sm transition duration-150 ease-in-out" />
            </div>
            <div class="flex justify-end space-x-3">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">บันทึก</button>
                <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">ยกเลิก</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#seniorTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/th.json" // Thai language pack
            },
            "pagingType": "full_numbers" // Show first, previous, next, last buttons
        });

        // Modal animations
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');

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

        window.editSenior = function(id, name, max) {
            document.getElementById('editName').value = name;
            document.getElementById('editMax').value = max;
            document.getElementById('editForm').action = '/admin/seniors/update/' + id;
            showModal();
        };

        window.closeModal = function() {
            hideModal();
        };

        // Close modal when clicking outside content
        editModal.addEventListener('click', function(event) {
            if (event.target === editModal) {
                hideModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !editModal.classList.contains('hidden')) {
                hideModal();
            }
        });

        // SweetAlert2 function for delete confirmation
        window.confirmDelete = function(seniorId) {
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
                focusConfirm: false,
                buttonsStyling: true,
                customClass: {
                    popup: 'rounded-3xl shadow-lg border border-gray-200', // ปรับเป็น rounded-3xl
                    title: 'text-xl font-bold text-gray-800 py-4',
                    htmlContainer: 'text-gray-700 leading-relaxed py-2',
                    icon: 'text-yellow-500 text-4xl my-4',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 mr-2',
                    cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 ml-2',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + seniorId).submit();
                }
            });
        };
    });
</script>
@endsection