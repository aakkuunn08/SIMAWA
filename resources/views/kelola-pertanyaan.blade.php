<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pertanyaan Tes Minat - SIMAWA ITH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }
        
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideIn 0.3s;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-4 md:p-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('tesminatbem.menu') }}" 
                   class="flex items-center gap-2 text-gray-600 hover:text-orange-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Menu</span>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 px-8 py-8">
                    <h1 class="text-white text-3xl md:text-4xl font-bold">Kelola Pertanyaan Tes Minat</h1>
                </div>

                <div id="messageContainer" class="hidden mx-8 mt-6"></div>

                <div class="px-8 py-6 border-b border-gray-200 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
                    <button onclick="openAddModal()" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Pertanyaan Baru</span>
                    </button>

                    <div class="relative w-full md:w-80">
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Cari pertanyaan..." 
                            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        >
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 w-20">No</th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Pertanyaan</th>
                                <th class="px-8 py-4 text-center text-sm font-semibold text-gray-700 w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="questionTableBody">
                            <tr>
                                <td colspan="3" class="px-8 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500"></div>
                                        <p>Memuat data...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Total: <span id="totalQuestions" class="font-semibold">0</span> pertanyaan
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="questionModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-800">Tambah Pertanyaan</h3>
                <button onclick="closeQuestionModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="questionForm" class="space-y-5">
                <input type="hidden" id="question_id" name="question_id">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea 
                        id="pertanyaan" 
                        name="pertanyaan" 
                        rows="4"
                        required
                        placeholder="Masukkan pertanyaan tes minat..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select id="kategori" name="kategori" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="HCC">HCC (Software)</option>
                        <option value="HERO">HERO (Hardware)</option>
                        <option value="Seni">Seni</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="MPM">MPM (Rohani)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeQuestionModal()" 
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Pertanyaan?</h3>
                <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus pertanyaan ini?</p>
                <div class="flex gap-3 justify-center">
                    <button onclick="closeDeleteModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                        Batal
                    </button>
                    <button onclick="confirmDelete()" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let allQuestions = [];
        let deleteQuestionId = null;
        let isEditMode = false;

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function showMessage(message, type = 'success') {
            const container = document.getElementById('messageContainer');
            const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
            container.innerHTML = `
                <div class="px-4 py-3 ${bgColor} border rounded-lg flex items-center justify-between">
                    <span>${message}</span>
                    <button onclick="this.parentElement.remove()" class="hover:opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>`;
            container.classList.remove('hidden');
            setTimeout(() => { container.classList.add('hidden'); }, 5000);
        }

        async function loadQuestions() {
            try {
                const response = await fetch('/tesminatbem/pertanyaan/data', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }
                });
                const data = await response.json();
                allQuestions = data.questions || [];
                renderQuestions(allQuestions);
            } catch (error) { showMessage('Gagal memuat data', 'error'); }
        }

        function renderQuestions(questions) {
            const tbody = document.getElementById('questionTableBody');
            document.getElementById('totalQuestions').textContent = questions.length;
            
            if (questions.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="px-8 py-12 text-center text-gray-500">Belum ada pertanyaan</td></tr>';
                return;
            }
            
            tbody.innerHTML = questions.map((q, index) => `
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-8 py-4 text-sm text-gray-800 font-medium">${index + 1}.</td>
                    <td class="px-8 py-4 text-sm text-gray-800">
                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold bg-orange-100 text-orange-600 rounded mb-1 uppercase">${q.kategori || 'Tanpa Kategori'}</span><br>
                        ${escapeHtml(q.pertanyaan)}
                    </td>
                    <td class="px-8 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="editQuestion(${q.id_soal})" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm">Edit</button>
                            <button onclick="deleteQuestion(${q.id_soal})" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm">Hapus</button>
                        </div>
                    </td>
                </tr>`).join('');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            renderQuestions(allQuestions.filter(q => q.pertanyaan.toLowerCase().includes(searchTerm)));
        });

        function openAddModal() {
            isEditMode = false;
            document.getElementById('modalTitle').textContent = 'Tambah Pertanyaan Baru';
            document.getElementById('questionForm').reset();
            document.getElementById('question_id').value = '';
            document.getElementById('questionModal').classList.add('active');
        }

        function closeQuestionModal() { document.getElementById('questionModal').classList.remove('active'); }

        function editQuestion(id) {
            isEditMode = true;
            const question = allQuestions.find(q => q.id_soal === id);
            if (!question) return;
            document.getElementById('modalTitle').textContent = 'Edit Pertanyaan';
            document.getElementById('question_id').value = question.id_soal;
            document.getElementById('pertanyaan').value = question.pertanyaan;
            document.getElementById('kategori').value = question.kategori || '';
            document.getElementById('questionModal').classList.add('active');
        }

        function deleteQuestion(id) {
            deleteQuestionId = id;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('active'); }

        async function confirmDelete() {
            try {
                const response = await fetch(`/tesminatbem/pertanyaan/${deleteQuestionId}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }
                });
                const data = await response.json();
                if (data.success) { showMessage('Dihapus!', 'success'); closeDeleteModal(); loadQuestions(); }
            } catch (error) { showMessage('Gagal!', 'error'); }
        }

        document.getElementById('questionForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = document.getElementById('question_id').value;
            const data = {
                pertanyaan: document.getElementById('pertanyaan').value.trim(),
                kategori: document.getElementById('kategori').value,
                skala_likert: 5
            };
            
            const url = id ? `/tesminatbem/pertanyaan/${id}` : '/tesminatbem/pertanyaan';
            const method = id ? 'PUT' : 'POST';
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify(data)
                });
                const res = await response.json();
                if (res.success) { showMessage(res.message, 'success'); closeQuestionModal(); loadQuestions(); }
                else { showMessage(res.message, 'error'); }
            } catch (error) { showMessage('Terjadi kesalahan', 'error'); }
        });

        document.addEventListener('DOMContentLoaded', loadQuestions);
    </script>
</body>
</html>