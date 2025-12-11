<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Minat UKM - SIMAWA ITH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .step-container {
            display: none;
        }
        .step-container.active {
            display: block;
        }
        
        /* Custom Radio Button Styling */
        .radio-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .radio-wrapper input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        
        .radio-circle {
            width: 40px;
            height: 40px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
        }
        
        .radio-wrapper:hover .radio-circle {
            border-color: #f97316;
            transform: scale(1.05);
        }
        
        .radio-wrapper input[type="radio"]:checked + .radio-circle {
            border-color: #f97316;
            background: #f97316;
            color: white;
        }
        
        .radio-number {
            font-size: 16px;
            font-weight: 600;
            color: #6b7280;
        }
        
        .radio-wrapper input[type="radio"]:checked + .radio-circle .radio-number {
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
            
            <!-- Container Utama -->
            <div class="bg-white shadow-lg rounded-lg border-t-4 border-orange-500 p-8">
                
                <!-- Header dengan Progress -->
                <div class="relative mb-8">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('home') }}" 
                       class="absolute left-0 top-0 flex items-center gap-2 text-gray-600 hover:text-orange-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">Kembali</span>
                    </a>
                    
                    <h1 class="text-center text-xl font-bold text-gray-800 mb-2">TES MINAT UKM</h1>
                    <div class="text-center text-sm text-gray-600" id="pageIndicator">
                        Hal <span id="currentPage">1</span> of 3
                    </div>
                </div>
                
                <!-- Step 1: Form Biodata -->
                <div id="step1" class="step-container active">
                    <h2 class="text-lg font-semibold text-gray-800 mb-6 text-center">FORM BIODATA MAHASISWA</h2>
                    
                    <form id="biodataForm" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" 
                                   id="nama_lengkap" 
                                   name="nama_lengkap" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                            <input type="text" 
                                   id="nim" 
                                   name="nim" 
                                   required
                                   pattern="[0-9]+"
                                   inputmode="numeric"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <p id="nimError" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                            <input type="text" 
                                   id="program_studi" 
                                   name="program_studi" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Angkatan</label>
                            <select id="angkatan" 
                                    name="angkatan" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="">Pilih Angkatan</option>
                            </select>
                        </div>

                        <div class="flex justify-center pt-4">
                            <button type="button" 
                                    onclick="goToStep2()"
                                    class="px-8 py-2 bg-orange-500 text-white rounded-full font-semibold hover:bg-orange-600 transition">
                                Selanjutnya
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Step 2: Kuesioner -->
                <div id="step2" class="step-container">
                    <h2 class="text-sm text-gray-600 mb-6">
                        Mohon isi setiap pertanyaan dengan jujur. Skala 1 hingga 5 dengan 1 = Sangat tidak setuju dan 5 = Sangat setuju.
                    </h2>

                    <form id="questionForm" class="space-y-6">
                        @foreach($soals as $index => $soal)
                        <!-- Pertanyaan {{ $index + 1 }} -->
                        <div class="border-b pb-6">
                            <p class="text-sm font-medium text-gray-800 mb-4">
                                {{ $index + 1 }}. {{ $soal->pertanyaan }}
                            </p>
                            <div class="flex justify-center gap-8">
                                @for($i = 1; $i <= $soal->skala_likert; $i++)
                                <label class="radio-wrapper">
                                    <input type="radio" name="q{{ $index + 1 }}" value="{{ $i }}" {{ $i == 1 ? 'required' : '' }}>
                                    <div class="radio-circle">
                                        <span class="radio-number">{{ $i }}</span>
                                    </div>
                                </label>
                                @endfor
                            </div>
                        </div>
                        @endforeach

                        <div class="flex justify-center gap-4 pt-4">
                            <button type="button" 
                                    onclick="goToStep1()"
                                    class="px-8 py-2 bg-gray-300 text-gray-700 rounded-full font-semibold hover:bg-gray-400 transition">
                                Kembali
                            </button>
                            <button type="button" 
                                    onclick="submitForm()"
                                    class="px-8 py-2 bg-orange-500 text-white rounded-full font-semibold hover:bg-orange-600 transition">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Step 3: Hasil Rekomendasi -->
                <div id="step3" class="step-container">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 text-center">REKOMENDASI UKM UNTUK KAMU</h2>
                    <p class="text-sm text-gray-600 mb-6 text-center">Berdasarkan jawaban yang kamu berikan</p>

                    <div class="flex flex-col items-center">
                        <div class="w-48 h-48 bg-white rounded-lg border-2 border-gray-300 flex items-center justify-center mb-4 overflow-hidden">
                            <img id="rekomendasiLogo" src="" alt="Logo UKM" class="max-w-full max-h-full object-contain">
                        </div>
                        
                        <h3 id="rekomendasiNama" class="text-xl font-bold text-gray-800 mb-2 text-center"></h3>
                        <p id="rekomendasiDeskripsi" class="text-sm text-gray-600 text-center max-w-md mb-6"></p>

                        <button type="button" 
                                onclick="window.location.href='{{ route('home') }}'"
                                class="px-8 py-2 bg-orange-500 text-white rounded-full font-semibold hover:bg-orange-600 transition">
                            Kembali ke Beranda
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        /**
         * ========================================
         * TES MINAT UKM - JavaScript Functions
         * ========================================
         */

        // Variable global untuk menyimpan data biodata
        let biodataData = {};

        /**
         * Generate dropdown tahun angkatan otomatis
         * Dimulai dari tahun 2022 hingga tahun sekarang + 1
         * Akan otomatis update setiap tahun berganti
         */
        document.addEventListener('DOMContentLoaded', function() {
            const angkatanSelect = document.getElementById('angkatan');
            const currentYear = new Date().getFullYear();
            const startYear = 2022;
            
            // Generate options dari tahun terbaru ke tahun 2022 (descending)
            for (let year = currentYear + 1; year >= startYear; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                angkatanSelect.appendChild(option);
            }

            // Setup NIM validation
            setupNIMValidation();
        });

        /**
         * Setup custom validation for NIM input field
         * Ensures only numeric input and shows custom error messages in English
         */
        function setupNIMValidation() {
            const nimInput = document.getElementById('nim');
            const nimError = document.getElementById('nimError');

            // Handle input event - only allow numbers
            nimInput.addEventListener('input', function(e) {
                // Remove any non-numeric characters
                const originalValue = this.value;
                const numericValue = this.value.replace(/[^0-9]/g, '');
                
                // If non-numeric characters were entered, show error
                if (originalValue !== numericValue) {
                    this.value = numericValue;
                    showNIMError('Please enter numbers only');
                } else if (numericValue.length > 0) {
                    // Valid numeric input
                    clearNIMError();
                    this.setCustomValidity('');
                }
            });

            // Handle invalid event - show custom error message
            nimInput.addEventListener('invalid', function(e) {
                e.preventDefault();
                
                if (this.validity.valueMissing) {
                    showNIMError('Please fill out this field');
                    this.setCustomValidity('Please fill out this field');
                } else if (this.validity.patternMismatch) {
                    showNIMError('Please enter numbers only');
                    this.setCustomValidity('Please enter numbers only');
                } else {
                    showNIMError('Please enter a valid NIM');
                    this.setCustomValidity('Please enter a valid NIM');
                }
            });

            // Clear error on focus
            nimInput.addEventListener('focus', function() {
                clearNIMError();
            });

            // Validate on blur
            nimInput.addEventListener('blur', function() {
                if (this.value.length > 0 && !this.value.match(/^[0-9]+$/)) {
                    showNIMError('Please enter numbers only');
                    this.setCustomValidity('Please enter numbers only');
                } else if (this.value.length === 0) {
                    clearNIMError();
                    this.setCustomValidity('');
                }
            });

            // Prevent paste of non-numeric content
            nimInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                const numericText = pastedText.replace(/[^0-9]/g, '');
                
                if (numericText !== pastedText) {
                    showNIMError('Please enter numbers only');
                }
                
                this.value = numericText;
                this.dispatchEvent(new Event('input'));
            });
        }

        /**
         * Show error message for NIM field
         */
        function showNIMError(message) {
            const nimInput = document.getElementById('nim');
            const nimError = document.getElementById('nimError');
            
            nimInput.classList.remove('border-gray-300', 'focus:ring-orange-500');
            nimInput.classList.add('border-red-500', 'focus:ring-red-500');
            nimError.textContent = message;
            nimError.classList.remove('hidden');
        }

        /**
         * Clear error message for NIM field
         */
        function clearNIMError() {
            const nimInput = document.getElementById('nim');
            const nimError = document.getElementById('nimError');
            
            nimInput.classList.remove('border-red-500', 'focus:ring-red-500');
            nimInput.classList.add('border-gray-300', 'focus:ring-orange-500');
            nimError.classList.add('hidden');
            nimInput.setCustomValidity('');
        }

        /**
         * Fungsi untuk pindah dari Step 1 (Biodata) ke Step 2 (Kuesioner)
         * Validasi form terlebih dahulu sebelum pindah
         */
        function goToStep2() {
            const form = document.getElementById('biodataForm');
            const nimInput = document.getElementById('nim');
            
            // Extra validation for NIM
            if (nimInput.value && !nimInput.value.match(/^[0-9]+$/)) {
                showNIMError('Please enter numbers only');
                nimInput.setCustomValidity('Please enter numbers only');
                nimInput.focus();
                return;
            } else {
                clearNIMError();
            }
            
            // Validasi form biodata
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Simpan data biodata ke variable global
            biodataData = {
                nama_lengkap: document.getElementById('nama_lengkap').value,
                nim: document.getElementById('nim').value,
                program_studi: document.getElementById('program_studi').value,
                angkatan: document.getElementById('angkatan').value
            };

            // Pindah ke step 2 dan update indicator
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step2').classList.add('active');
            document.getElementById('currentPage').textContent = '2';
            window.scrollTo(0, 0);
        }

        /**
         * Fungsi untuk kembali dari Step 2 (Kuesioner) ke Step 1 (Biodata)
         */
        function goToStep1() {
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step1').classList.add('active');
            document.getElementById('currentPage').textContent = '1';
            window.scrollTo(0, 0);
        }

        /**
         * Fungsi untuk submit form dan mendapatkan rekomendasi UKM
         * Mengirim data ke server via AJAX dan menampilkan hasil
         */
        async function submitForm() {
            const form = document.getElementById('questionForm');
            
            // Validasi form pertanyaan
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Kumpulkan semua jawaban dari kuesioner
            const answers = {
                q1: document.querySelector('input[name="q1"]:checked').value,
                q2: document.querySelector('input[name="q2"]:checked').value,
                q3: document.querySelector('input[name="q3"]:checked').value,
                q4: document.querySelector('input[name="q4"]:checked').value,
                q5: document.querySelector('input[name="q5"]:checked').value,
                q6: document.querySelector('input[name="q6"]:checked').value
            };

            // Gabungkan biodata dengan jawaban
            const formData = {
                ...biodataData,
                ...answers
            };

            try {
                // Kirim data ke server menggunakan Fetch API
                const response = await fetch('{{ route("tesminat.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                // Jika berhasil, tampilkan hasil rekomendasi
                if (result.success) {
                    document.getElementById('rekomendasiLogo').src = result.rekomendasi.logo;
                    document.getElementById('rekomendasiNama').textContent = result.rekomendasi.nama;
                    document.getElementById('rekomendasiDeskripsi').textContent = result.rekomendasi.deskripsi;

                    // Pindah ke step 3 (Hasil Rekomendasi)
                    document.getElementById('step2').classList.remove('active');
                    document.getElementById('step3').classList.add('active');
                    document.getElementById('currentPage').textContent = '3';
                    window.scrollTo(0, 0);
                } else {
                    alert(result.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
            }
        }
    </script>
</body>
</html>
