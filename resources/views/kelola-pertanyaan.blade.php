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
            
            <!-- Header dengan tombol kembali -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('tesminatbem.menu') }}" 
                   class="flex items-center gap-2 text-gray-600 hover:text-orange-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Menu</span>
                </a>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 px-8 py-8">
                    <h1 class="text-white text-3xl md:text-4xl font-bold">Kelola Pertanyaan Tes Minat</h1>
                </div>

                <!-- Success/Error Messages -->
                <div id="messageContainer" class="hidden mx-8 mt-6"></div>

                <!-- Action Bar -->
                <div class="px-8 py-6 border-b border-gray-200 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
                    <!-- Tombol Tambah -->
                    <button onclick="openAddModal()" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Pertanyaan Baru</span>
                    </button>

                    <!-- Search Bar -->
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

                <!-- Table Container -->
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
                            <!-- Data akan dimuat via JavaScript -->
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

                <!-- Footer Info -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Total: <span id="totalQuestions" class="font-semibold">0</span> pertanyaan
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Add/Edit Pertanyaan -->
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
                
                <!-- Pertanyaan -->
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
                    <p class="mt-1 text-xs text-gray-500">Contoh: Saya tertarik di bidang seni atau kreatif</p>
                </div>

                <!-- Buttons -->
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

    <!-- Modal Delete Confirmation -->
    <div id="deleteModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="text-center">
                <!-- Icon Warning -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <!-- Title -->
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Pertanyaan?</h3>
                
                <!-- Message -->
                <p class="text-sm text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus pertanyaan ini? Data yang dihapus tidak dapat dikembalikan.
                </p>
                
                <!-- Buttons -->
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
        // Global variables
        let allQuestions = [];
        let deleteQuestionId = null;
        let isEditMode = false;

        // Get CSRF token
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // Show message
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
                </div>
            `;
            container.classList.remove('hidden');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                container.classList.add('hidden');
            }, 5000);
        }

        // Load questions from database
        async function loadQuestions() {
            try {
                const response = await fetch('/tesminatbem/pertanyaan/data', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                });
                
                if (!response.ok) throw new Error('Gagal memuat data');
                
                const data = await response.json();
                allQuestions = data.questions || [];
                renderQuestions(allQuestions);
            } catch (error) {
                console.error('Error:', error);
                showMessage('Gagal memuat data pertanyaan', 'error');
            }
        }

        // Render questions to table
        function renderQuestions(questions) {
            const tbody = document.getElementById('questionTableBody');
            const totalEl = document.getElementById('totalQuestions');
            
            totalEl.textContent = questions.length;
            
            if (questions.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="px-8 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-lg font-medium">Belum ada pertanyaan</p>
                                <p class="text-sm">Klik tombol "Tambah Pertanyaan Baru" untuk menambah</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            tbody.innerHTML = questions.map((q, index) => `
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-8 py-4 text-sm text-gray-800 font-medium">${index + 1}.</td>
                    <td class="px-8 py-4 text-sm text-gray-800">${escapeHtml(q.pertanyaan)}</td>
                    <td class="px-8 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="editQuestion(${q.id_soal})" 
                                    class="inline-flex items-center gap-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm"
                                    title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                <span>Edit</span>
                            </button>
                            <button onclick="deleteQuestion(${q.id_soal})" 
                                    class="inline-flex items-center gap-1 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition font-medium text-sm"
                                    title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filtered = allQuestions.filter(q => 
                q.pertanyaan.toLowerCase().includes(searchTerm)
            );
            renderQuestions(filtered);
        });

        // Modal functions
        function openAddModal() {
            isEditMode = false;
            document.getElementById('modalTitle').textContent = 'Tambah Pertanyaan Baru';
            document.getElementById('questionForm').reset();
            document.getElementById('question_id').value = '';
            document.getElementById('questionModal').classList.add('active');
        }

        function closeQuestionModal() {
            document.getElementById('questionModal').classList.remove('active');
            document.getElementById('questionForm').reset();
        }

        function editQuestion(id) {
            isEditMode = true;
            const question = allQuestions.find(q => q.id_soal === id);
            if (!question) return;
            
            document.getElementById('modalTitle').textContent = 'Edit Pertanyaan';
            document.getElementById('question_id').value = question.id_soal;
            document.getElementById('pertanyaan').value = question.pertanyaan;
            document.getElementById('questionModal').classList.add('active');
        }

        function deleteQuestion(id) {
            deleteQuestionId = id;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            deleteQuestionId = null;
        }

        async function confirmDelete() {
            if (!deleteQuestionId) return;
            
            try {
                const response = await fetch(`/tesminatbem/pertanyaan/${deleteQuestionId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage('Pertanyaan berhasil dihapus', 'success');
                    closeDeleteModal();
                    loadQuestions(); // Reload data
                } else {
                    showMessage(data.message || 'Gagal menghapus pertanyaan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Terjadi kesalahan saat menghapus pertanyaan', 'error');
            }
        }

        // Form submit handler
        document.getElementById('questionForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const questionId = document.getElementById('question_id').value;
            const pertanyaan = document.getElementById('pertanyaan').value.trim();
            
            if (!pertanyaan) {
                showMessage('Pertanyaan tidak boleh kosong', 'error');
                return;
            }
            
            const url = questionId 
                ? `/tesminatbem/pertanyaan/${questionId}` 
                : '/tesminatbem/pertanyaan';
            
            const method = questionId ? 'PUT' : 'POST';
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({
                        pertanyaan: pertanyaan,
                        skala_likert: 5 // Default skala likert 1-5
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    closeQuestionModal();
                    loadQuestions(); // Reload data
                } else {
                    showMessage(data.message || 'Gagal menyimpan pertanyaan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Terjadi kesalahan saat menyimpan pertanyaan', 'error');
            }
        });

        // Close modal when clicking outside
        document.getElementById('questionModal').addEventListener('click', function(e) {
            if (e.target === this) closeQuestionModal();
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (document.getElementById('questionModal').classList.contains('active')) {
                    closeQuestionModal();
                }
                if (document.getElementById('deleteModal').classList.contains('active')) {
                    closeDeleteModal();
                }
            }
        });

        // Load questions on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadQuestions();
        });
    </script>
</body>
</html>
