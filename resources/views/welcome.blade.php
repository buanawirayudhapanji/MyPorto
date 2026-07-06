<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#FAFAF8] text-[#17181C] dark:bg-[#0A0B0F] dark:text-[#F3F1EA] transition-colors duration-200 antialiased relative overflow-x-hidden">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=Instrument+Sans:wght@500;600;700&display=swap');

            .font-display { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; letter-spacing: -0.02em; }
            .font-mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }

            .cursor-blink { animation: blink 1.1s steps(1) infinite; }
            @keyframes blink { 50% { opacity: 0; } }

            ::selection { background: #D6A34E; color: #0A0B0F; }
        </style>

        <!-- Ambient Background Glow (single, restrained) -->
        <div class="absolute inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 left-1/2 -translate-x-1/2 size-[700px] rounded-full bg-[#D6A34E]/[0.06] dark:bg-[#D6A34E]/[0.08] blur-[140px]"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Navigation Bar -->
            <nav class="flex items-center justify-between pb-6 border-b border-zinc-200/60 dark:border-[#1F212B] mb-16">
                <a href="#" class="text-lg font-display font-bold tracking-tight text-[#17181C] dark:text-[#F3F1EA] flex items-center gap-2">
                    <span class="size-7 rounded-md bg-[#D6A34E] flex items-center justify-center text-[#0A0B0F] font-mono font-bold text-sm">P</span>
                    <span>MyPorto</span>
                </a>

                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <div class="mr-2">
                        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" size="sm">
                            <flux:radio value="light" icon="sun" />
                            <flux:radio value="dark" icon="moon" />
                            <flux:radio value="system" icon="computer-desktop" />
                        </flux:radio.group>
                    </div>

                    @auth
                        <flux:button href="{{ route('dashboard') }}" size="sm" class="!bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none">
                            {{ __('Dashboard') }}
                        </flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" variant="ghost" size="sm">
                            {{ __('Log in') }}
                        </flux:button>
                        <flux:button href="{{ route('register') }}" size="sm" class="!bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none">
                            {{ __('Daftar Sekarang') }}
                        </flux:button>
                    @endauth
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="space-y-24">
                <section class="text-center max-w-3xl mx-auto space-y-7 pt-10">
                    <span class="inline-flex items-center gap-2 rounded-md border border-[#D6A34E]/30 bg-white/60 dark:bg-[#14151B] px-3 py-1.5 font-mono text-xs text-[#8A6A2A] dark:text-[#D6A34E]">
                        <span class="size-1.5 rounded-full bg-[#D6A34E] cursor-blink"></span>
                        <span class="font-semibold">$</span>
                        <span>{{ __('Platform Portofolio Instan untuk IT Professional') }}</span>
                    </span>

                    <h1 class="font-display text-4xl sm:text-5xl font-bold tracking-tight leading-[1.1] text-[#17181C] dark:text-[#F3F1EA]">
                        {{ __('Pamerkan Karya Terbaikmu dalam 5 Menit') }}
                    </h1>
                    <p class="text-base sm:text-lg text-zinc-500 dark:text-[#8D8D93] leading-relaxed font-normal max-w-2xl mx-auto">
                        {{ __('Platform instan, minimalis, dan profesional untuk memamerkan proyek, skill utama, dan kontak publik Anda. Didesain khusus agar rekruter dan klien terpukau dalam 3 detik pertama.') }}
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-6">
                        @auth
                            <flux:button href="{{ route('dashboard') }}" icon="arrow-right" class="w-full sm:w-auto !bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none shadow-[0_0_0_1px_rgba(214,163,78,0.15)]">
                                {{ __('Masuk Ke Dashboard') }}
                            </flux:button>
                        @else
                            <flux:button href="{{ route('register') }}" icon="sparkles" class="w-full sm:w-auto !bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none shadow-[0_0_0_1px_rgba(214,163,78,0.15)]">
                                {{ __('Mulai Buat Portofolio') }}
                            </flux:button>
                            <flux:button href="{{ route('login') }}" variant="ghost" class="w-full sm:w-auto">
                                {{ __('Masuk ke Akun') }}
                            </flux:button>
                        @endauth
                    </div>
                </section>

                <!-- Features Showcase -->
                <section class="space-y-12">
                    <div class="text-center max-w-xl mx-auto space-y-2">
                        <h2 class="font-display text-2xl sm:text-3xl font-bold tracking-tight">{{ __('Semua Fitur yang Anda Butuhkan') }}</h2>
                        <p class="text-sm text-zinc-400 dark:text-[#6E7080]">{{ __('Didesain rapi, berkinerja tinggi, dan anti-pusing untuk kreator.') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Feature 1 -->
                        <div class="p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] bg-white/50 dark:bg-[#14151B] space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="size-9 rounded-lg bg-[#D6A34E]/10 flex items-center justify-center text-[#B8842F] dark:text-[#D6A34E]">
                                    <flux:icon name="user" class="size-4.5" />
                                </div>
                                <span class="font-mono text-[11px] text-zinc-400 dark:text-[#5B5D6B]">profile.json</span>
                            </div>
                            <h3 class="text-lg font-display font-semibold">{{ __('Profil & Identity Lengkap') }}</h3>
                            <p class="text-sm text-zinc-500 dark:text-[#8D8D93] leading-relaxed">
                                {{ __('Unggah foto profil, deskripsi profil, riwayat pendidikan/kelulusan, dokumen CV, dan link sosial (GitHub/LinkedIn) dalam satu halaman ringkas.') }}
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] bg-white/50 dark:bg-[#14151B] space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="size-9 rounded-lg bg-[#D6A34E]/10 flex items-center justify-center text-[#B8842F] dark:text-[#D6A34E]">
                                    <flux:icon name="folder" class="size-4.5" />
                                </div>
                                <span class="font-mono text-[11px] text-zinc-400 dark:text-[#5B5D6B]">projects/</span>
                            </div>
                            <h3 class="text-lg font-display font-semibold">{{ __('Manajemen Proyek Dinamis') }}</h3>
                            <p class="text-sm text-zinc-500 dark:text-[#8D8D93] leading-relaxed">
                                {{ __('Unggah banyak foto sekaligus (Drag & Drop), susun urutan gambar, kelompokkan kategori IT, serta buat poin-poin fitur utama dengan mudah.') }}
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] bg-white/50 dark:bg-[#14151B] space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="size-9 rounded-lg bg-[#D6A34E]/10 flex items-center justify-center text-[#B8842F] dark:text-[#D6A34E]">
                                    <flux:icon name="link" class="size-4.5" />
                                </div>
                                <span class="font-mono text-[11px] text-zinc-400 dark:text-[#5B5D6B]">public/[username]</span>
                            </div>
                            <h3 class="text-lg font-display font-semibold">{{ __('Public Link Instan') }}</h3>
                            <p class="text-sm text-zinc-500 dark:text-[#8D8D93] leading-relaxed">
                                {{ __('Portofolio publik Anda bisa diakses langsung via /username tanpa rekruter harus login. Ringkas, responsif HP, dan ramah SEO.') }}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Technology Icons showcase -->
                <section class="bg-white/60 dark:bg-[#14151B] border border-zinc-200/60 dark:border-[#1F212B] rounded-xl p-8 text-center space-y-6">
                    <h3 class="font-mono text-xs text-zinc-400 dark:text-[#5B5D6B] uppercase tracking-widest">{{ __('Mendukung Ratusan Teknologi Modern') }}</h3>
                    <div class="flex flex-wrap justify-center items-center gap-6 opacity-50 dark:opacity-40">
                        <x-tech-icon name="laravel" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="php" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="react" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="vue" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="tailwindcss" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="docker" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="mysql" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="redis" class="size-8 grayscale hover:grayscale-0 transition" />
                        <x-tech-icon name="typescript" class="size-8 grayscale hover:grayscale-0 transition" />
                    </div>
                </section>

                <!-- Bottom Call To Action -->
                <section class="bg-[#0A0B0F] rounded-2xl p-8 sm:p-12 text-center text-[#F3F1EA] space-y-6 relative overflow-hidden border border-[#D6A34E]/20">
                    <div class="absolute -top-16 -right-16 size-48 rounded-full bg-[#D6A34E]/10 blur-[80px]"></div>

                    <h2 class="font-display text-3xl sm:text-4xl font-bold tracking-tight">
                        {{ __('Siap Pamerkan Karya Terbaikmu?') }}
                    </h2>
                    <p class="text-[#B9BAC2] max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
                        {{ __('Bergabunglah sekarang dan miliki halaman portofolio publik yang rapi, cepat, dan profesional dalam hitungan menit.') }}
                    </p>
                    <div class="pt-4">
                        @auth
                            <flux:button href="{{ route('dashboard') }}" class="!bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] font-semibold !border-none">
                                {{ __('Masuk Ke Dashboard') }}
                            </flux:button>
                        @else
                            <flux:button href="{{ route('register') }}" class="!bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] font-semibold !border-none">
                                {{ __('Daftar Sekarang (Gratis)') }}
                            </flux:button>
                        @endauth
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <footer class="mt-20 pt-8 border-t border-zinc-200 dark:border-[#1F212B] text-center font-mono text-xs text-zinc-400 dark:text-[#5B5D6B]">
                <p>&copy; {{ date('Y') }} MyPorto. All rights reserved.</p>
            </footer>
        </div>

        @fluxScripts
    </body>
</html>