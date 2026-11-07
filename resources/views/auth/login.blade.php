
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#f3f8f3] px-4 py-8">
        <div class="w-full max-w-6xl bg-white rounded-[28px] shadow-2xl shadow-green-900/10 overflow-hidden grid grid-cols-1 md:grid-cols-2">

            <!-- Left Panel -->
            <div class="relative hidden md:flex flex-col justify-between bg-gradient-to-br from-green-800 via-green-700 to-emerald-600 p-12 text-white overflow-hidden">

                <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-white/5"></div>
                <div class="absolute -bottom-32 -right-24 w-96 h-96 rounded-full bg-white/10"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center backdrop-blur">
                            <i class="fas fa-leaf text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-extrabold tracking-wide">FreshAI</h1>
                            <p class="text-xs text-green-100 tracking-widest">SMART FRESHNESS DETECTION</p>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 py-12">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 text-sm mb-6 backdrop-blur">
                        <span class="w-2 h-2 rounded-full bg-lime-300"></span>
                        AI Powered Technology
                    </span>

                    <h2 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-6">
                        Kenali Kesegaran,
                        <span class="text-lime-300">Jaga Kualitas.</span>
                    </h2>

                    <p class="text-green-100 leading-relaxed text-base max-w-md">
                        Deteksi tingkat kesegaran buah dan sayuran dengan teknologi kecerdasan buatan secara cepat dan praktis.
                    </p>

                    <div class="mt-10 grid grid-cols-3 gap-3">
                        <div class="bg-white/10 backdrop-blur rounded-2xl p-4">
                            <i class="fas fa-apple-whole text-2xl text-lime-300 mb-3"></i>
                            <p class="text-sm font-semibold">Buah</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-2xl p-4">
                            <i class="fas fa-carrot text-2xl text-lime-300 mb-3"></i>
                            <p class="text-sm font-semibold">Sayuran</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-2xl p-4">
                            <i class="fas fa-brain text-2xl text-lime-300 mb-3"></i>
                            <p class="text-sm font-semibold">Artificial AI</p>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 text-sm text-green-100">
                    © {{ date('Y') }} FreshAI. All rights reserved.
                </div>
            </div>

            <!-- Right Panel -->
            <div class="flex items-center justify-center p-7 sm:p-12 lg:p-16">
                <div class="w-full max-w-md">

                    <div class="mb-10">
                        <div class="md:hidden flex items-center gap-3 mb-10">
                            <div class="w-11 h-11 rounded-xl bg-green-700 text-white flex items-center justify-center">
                                <i class="fas fa-leaf text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-extrabold text-green-800">FreshAI</h1>
                                <p class="text-xs text-gray-500">Smart Freshness Detection</p>
                            </div>
                        </div>

                        <span class="text-sm font-semibold text-green-700">SELAMAT DATANG KEMBALI</span>
                        <h2 class="text-3xl font-extrabold text-gray-800 mt-3">
                            Masuk ke Akun
                        </h2>
                        <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                            Silakan masuk untuk mulai menggunakan layanan deteksi kesegaran FreshAI.
                        </p>
                    </div>

                    <x-auth-session-status class="mb-5" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Email
                            </label>

                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </span>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="nama@email.com"
                                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 placeholder-gray-400 focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-100 outline-none transition"
                                >
                            </div>

                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="text-sm font-semibold text-gray-700">
                                    Password
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-green-700 hover:text-green-900">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>

                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                    class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 placeholder-gray-400 focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-100 outline-none transition"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 px-4 text-gray-400 hover:text-green-700"
                                    aria-label="Tampilkan password"
                                >
                                    <i id="password-icon" class="fas fa-eye"></i>
                                </button>
                            </div>

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember -->
                        <div class="flex items-center">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 rounded border-gray-300 text-green-700 focus:ring-green-600"
                            >
                            <label for="remember_me" class="ms-2 text-sm text-gray-600">
                                Ingat saya
                            </label>
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full py-3.5 rounded-xl bg-green-700 hover:bg-green-800 text-white font-bold shadow-lg shadow-green-700/20 hover:shadow-green-700/30 transition duration-300 flex items-center justify-center gap-3"
                        >
                            Masuk Sekarang
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-xs text-gray-400">
                            Dengan masuk, Anda dapat mengakses layanan FreshAI.
                        </p>
                    </div>

                    <div class="mt-8 flex items-center justify-center gap-2 text-xs text-gray-400">
                        <i class="fas fa-shield-alt text-green-600"></i>
                        Sistem deteksi kesegaran berbasis AI
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('password-icon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</x-guest-layout>
