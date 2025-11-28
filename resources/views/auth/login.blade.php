<x-guest-layout>

    {{-- Sembunyikan logo Laravel default di layout guest --}}
    <style>
        .authentication-card-logo,
        .application-logo {
            display: none !important;
        }
    </style>

    {{-- JANGAN pakai min-h-screen di sini, karena sudah dipakai di guest layout --}}
    <div class="flex flex-col justify-center items-center bg-white px-4 py-8">

        <!-- Logo -->
        <div class="mb-6">
            <img src="/images/logobem.png" class="w-40 mx-auto" alt="Logo bem">
            {{-- Ganti "/your-logo.png" dengan path logo kamu --}}
        </div>

        <!-- Title -->
        <h1 class="text-3xl font-extrabold text-black text-center">SELAMAT DATANG</h1>
        <p class="text-gray-700 text-center mt-1 mb-8 text-lg">
            Silahkan Login Untuk Melanjutkan
        </p>

        <!-- Login Form Box -->
        <div class="w-full max-w-md bg-white p-6 rounded-lg">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div class="mt-4">
                    <label class="block text-sm font-semibold mb-1">Username</label>
                    <input id="username"
                           type="text"
                           name="username"
                           value="{{ old('username') }}"
                           required autofocus
                           class="w-full border border-gray-400 rounded-md px-3 py-2 focus:ring-orange-400 focus:border-orange-400" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label class="block text-sm font-semibold mb-1">Password</label>

                    <div class="relative">
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               class="w-full border border-gray-400 rounded-md px-3 py-2 focus:ring-orange-400 focus:border-orange-400" />

                        <!-- Show/Hide Password -->
                        <span onclick="togglePassword()"
                              class="absolute right-3 top-3 text-blue-500 text-sm cursor-pointer">
                            Tampilkan
                        </span>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mt-4 flex items-center">
                    <input id="remember" 
                           type="checkbox" 
                           name="remember"
                           class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                    <label for="remember" class="ml-2 text-sm text-gray-700">
                        Ingat Saya
                    </label>
                </div>

                <!-- Login Button -->
                <div class="mt-6">
                    <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-full font-semibold transition">
                        LOGIN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById('password');
            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>
</x-guest-layout>
