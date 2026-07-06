<div class="w-full space-y-8">
    <!-- Header -->
    <div class="border-b border-zinc-200/60 dark:border-[#1F212B] pb-4">
        <flux:heading size="xl" level="1" class="font-display font-bold">{{ __('Dashboard Overview') }}</flux:heading>
        <flux:subheading size="sm" class="text-zinc-400 dark:text-[#6E7080]">{{ __('Pantau performa kunjungan portofolio publik Anda secara real-time.') }}</flux:subheading>
    </div>

    <!-- Quick Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Views -->
        <div class="bg-white/50 dark:bg-[#14151B] p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-mono text-zinc-400 dark:text-[#5B5D6B] uppercase tracking-wider">{{ __('Kunjungan Profil') }}</p>
                <h3 class="text-3xl font-display font-bold text-zinc-900 dark:text-[#F3F1EA]">{{ number_format($totalProfileViews) }}</h3>
                <p class="text-[10px] text-zinc-400 dark:text-[#5B5D6B]">{{ __('Total view halaman utama portofolio') }}</p>
            </div>
            <div class="size-12 rounded-xl bg-[#D6A34E]/10 flex items-center justify-center text-[#B8842F] dark:text-[#D6A34E]">
                <flux:icon name="eye" class="size-6" />
            </div>
        </div>

        <!-- Card 2: Clicks -->
        <div class="bg-white/50 dark:bg-[#14151B] p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-mono text-zinc-400 dark:text-[#5B5D6B] uppercase tracking-wider">{{ __('Klik Proyek') }}</p>
                <h3 class="text-3xl font-display font-bold text-zinc-900 dark:text-[#F3F1EA]">{{ number_format($totalProjectClicks) }}</h3>
                <p class="text-[10px] text-zinc-400 dark:text-[#5B5D6B]">{{ __('Total klik untuk melihat detail proyek') }}</p>
            </div>
            <div class="size-12 rounded-xl bg-[#D6A34E]/10 flex items-center justify-center text-[#B8842F] dark:text-[#D6A34E]">
                <flux:icon name="cursor-arrow-rays" class="size-6" />
            </div>
        </div>

        <!-- Card 3: Total Projects -->
        <div class="bg-white/50 dark:bg-[#14151B] p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-mono text-zinc-400 dark:text-[#5B5D6B] uppercase tracking-wider">{{ __('Total Karya') }}</p>
                <h3 class="text-3xl font-display font-bold text-zinc-900 dark:text-[#F3F1EA]">{{ number_format($totalProjects) }}</h3>
                <p class="text-[10px] text-zinc-400 dark:text-[#5B5D6B]">{{ __('Jumlah proyek terdaftar di portofolio') }}</p>
            </div>
            <div class="size-12 rounded-xl bg-[#D6A34E]/10 flex items-center justify-center text-[#B8842F] dark:text-[#D6A34E]">
                <flux:icon name="folder" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Main Chart & Analysis Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- SVG Line Chart (7 Days Activity) -->
        <div class="bg-white/50 dark:bg-[#14151B] p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="md" level="2" class="font-display font-bold">{{ __('Aktivitas 7 Hari Terakhir') }}</flux:heading>
                    <flux:subheading size="xs" class="text-zinc-400 dark:text-[#6E7080]">{{ __('Perbandingan Kunjungan Profil vs Klik Proyek') }}</flux:subheading>
                </div>
                <!-- Legend -->
                <div class="flex items-center gap-4 text-xs font-mono">
                    <div class="flex items-center gap-1.5">
                        <span class="size-2.5 rounded-full bg-[#D6A34E]"></span>
                        <span class="text-zinc-500 dark:text-[#8D8D93]">{{ __('Views') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="size-2.5 rounded-full bg-zinc-400 dark:bg-zinc-600"></span>
                        <span class="text-zinc-500 dark:text-[#8D8D93]">{{ __('Clicks') }}</span>
                    </div>
                </div>
            </div>

            <!-- SVG Container -->
            <div class="relative w-full aspect-[25/10] bg-zinc-50/50 dark:bg-[#0A0B0F]/50 rounded-lg p-4 border border-zinc-200/40 dark:border-[#1F212B]/40">
                <svg viewBox="0 0 500 200" class="w-full h-full overflow-visible">
                    <!-- Grid Lines -->
                    <line x1="0" y1="20" x2="500" y2="20" stroke="currentColor" class="text-zinc-200/50 dark:text-zinc-800/30" stroke-dasharray="3,3" />
                    <line x1="0" y1="100" x2="500" y2="100" stroke="currentColor" class="text-zinc-200/50 dark:text-zinc-800/30" stroke-dasharray="3,3" />
                    <line x1="0" y1="180" x2="500" y2="180" stroke="currentColor" class="text-zinc-200/80 dark:text-zinc-800/50" />

                    @if ($maxVal > 0)
                        <!-- Chart Lines paths -->
                        <!-- 1. Clicks Line (zinc-400/600) -->
                        <path d="{{ $chartPointsClicks }}" fill="none" stroke="currentColor" class="text-zinc-400 dark:text-zinc-600" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        
                        <!-- 2. Views Line (Gold Accent) -->
                        <path d="{{ $chartPointsViews }}" fill="none" stroke="#D6A34E" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />

                        <!-- Data Points Dot markers -->
                        @foreach ($dailyStats as $index => $stat)
                            @php
                                $x = ($index * (500 / 6));
                                $yViews = 180 - (($stat['views'] / $maxVal) * 160);
                                $yClicks = 180 - (($stat['clicks'] / $maxVal) * 160);
                            @endphp
                            <!-- Clicks dot -->
                            <circle cx="{{ $x }}" cy="{{ $yClicks }}" r="4" fill="currentColor" class="text-zinc-400 dark:text-zinc-600 hover:r-6 transition-all duration-150 cursor-pointer" />
                            <!-- Views dot -->
                            <circle cx="{{ $x }}" cy="{{ $yViews }}" r="4" fill="#D6A34E" class="hover:r-6 transition-all duration-150 cursor-pointer" />
                        @endforeach
                    @endif
                </svg>

                <!-- X Axis Date Labels -->
                <div class="flex justify-between mt-3 text-[10px] font-mono text-zinc-400 dark:text-[#5B5D6B]">
                    @foreach ($dailyStats as $stat)
                        <span>{{ $stat['date'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Projects Ranking List -->
        <div class="bg-white/50 dark:bg-[#14151B] p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B] space-y-6">
            <div>
                <flux:heading size="md" level="2" class="font-display font-bold">{{ __('Karya Terpopuler') }}</flux:heading>
                <flux:subheading size="xs" class="text-zinc-400 dark:text-[#6E7080]">{{ __('Berdasarkan jumlah klik pengunjung.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                @forelse ($topProjects as $index => $project)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-50/50 dark:bg-[#0A0B0F]/30 border border-zinc-200/40 dark:border-[#1F212B]/40">
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-sm font-bold text-[#D6A34E]">#{{ $index + 1 }}</span>
                            <div>
                                <h4 class="text-xs font-bold text-zinc-900 dark:text-[#F3F1EA] line-clamp-1">{{ $project->title }}</h4>
                                <p class="text-[10px] text-zinc-400 dark:text-[#5B5D6B]">{{ $project->category }}</p>
                            </div>
                        </div>
                        <flux:badge size="sm" variant="subtle" class="bg-[#D6A34E]/10 text-[#8A6A2A] dark:text-[#D6A34E] border-none font-mono text-[10px]">
                            {{ $project->clicks_count }} {{ __('klik') }}
                        </flux:badge>
                    </div>
                @empty
                    <div class="text-center py-8 text-zinc-400 dark:text-[#5B5D6B] italic font-mono text-xs">
                        {{ __('Belum ada aktivitas klik proyek.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Optimization Tips section -->
    <div class="bg-[#0A0B0F] rounded-xl p-6 border border-[#D6A34E]/20 text-[#F3F1EA] space-y-4 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 size-48 rounded-full bg-[#D6A34E]/10 blur-[80px]"></div>

        <div class="flex items-center gap-3">
            <div class="size-9 rounded-lg bg-[#D6A34E]/20 flex items-center justify-center text-[#D6A34E]">
                <flux:icon name="sparkles" class="size-5" />
            </div>
            <h3 class="font-display text-base font-bold">{{ __('Tips Optimasi Portofolio Anda') }}</h3>
        </div>

        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-zinc-400 leading-relaxed pl-1">
            <li class="flex items-start gap-2.5">
                <span class="text-[#D6A34E] font-bold">•</span>
                <span>{{ __('Tambahkan link Live Demo di setiap proyek untuk meningkatkan interaksi klik pengunjung hingga 40%.') }}</span>
            </li>
            <li class="flex items-start gap-2.5">
                <span class="text-[#D6A34E] font-bold">•</span>
                <span>{{ __('Tampilkan minimal 2-3 gambar berkualitas tinggi untuk memberikan gambaran interface yang detail.') }}</span>
            </li>
            <li class="flex items-start gap-2.5">
                <span class="text-[#D6A34E] font-bold">•</span>
                <span>{{ __('Tautkan akun GitHub dan LinkedIn Anda pada profil agar rekruter dapat menghubungi Anda dengan mudah.') }}</span>
            </li>
            <li class="flex items-start gap-2.5">
                <span class="text-[#D6A34E] font-bold">•</span>
                <span>{{ __('Update Keahlian Utama (Tags) agar profil Anda lebih mudah ditemukan melalui pencarian kategori filter.') }}</span>
            </li>
        </ul>
    </div>
</div>
