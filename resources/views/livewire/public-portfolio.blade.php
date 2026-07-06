<div class="space-y-16">
    <!-- Hero / Profile Section (Glassmorphism card) -->
    <section class="bg-white/50 dark:bg-[#14151B] border border-zinc-200/60 dark:border-[#1F212B] p-6 sm:p-8 rounded-xl shadow-sm grid grid-cols-1 md:grid-cols-3 gap-8 items-center transition-all duration-300">
        <!-- Avatar and Actions Column -->
        <div class="flex flex-col items-center md:items-start text-center md:text-left gap-5 md:col-span-1 border-b md:border-b-0 md:border-r border-zinc-200/60 dark:border-[#1F212B]/60 pb-6 md:pb-0 md:pr-8">
            <div class="relative group">
                @if ($user->avatar_path)
                    <img src="{{ asset('storage/' . $user->avatar_path) }}" class="size-32 sm:size-36 rounded-full object-cover border border-[#D6A34E]/20 shadow-md group-hover:scale-[1.02] transition-transform duration-300" alt="{{ $user->name }}" />
                @else
                    <div class="size-32 sm:size-36 rounded-full bg-[#D6A34E] text-[#0A0B0F] flex items-center justify-center text-3xl font-mono font-bold shadow-md">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>

            <div class="space-y-1 mt-1">
                <flux:heading size="xl" level="1" class="font-display font-bold tracking-tight text-[#17181C] dark:text-[#F3F1EA]">{{ $user->name }}</flux:heading>
                @if ($user->job_title)
                    <p class="text-zinc-500 dark:text-[#8D8D93] font-medium text-sm tracking-wide">{{ $user->job_title }}</p>
                @endif
                @if ($user->status)
                    <span class="inline-flex items-center gap-2 rounded-md border border-[#D6A34E]/30 bg-white/60 dark:bg-[#0A0B0F] px-2.5 py-1 font-mono text-[10px] text-[#8A6A2A] dark:text-[#D6A34E] mt-2">
                        {{ $user->status }}
                    </span>
                @endif
            </div>

            <!-- Download CV (Strategic Primary Action) -->
            <div class="flex flex-wrap gap-3 mt-2 justify-center md:justify-start w-full">
                @if ($user->cv_path)
                    <flux:button href="{{ asset('storage/' . $user->cv_path) }}" target="_blank" icon="arrow-down-tray" class="w-full sm:w-auto shadow-sm !bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none font-semibold">
                        {{ __('Download CV') }}
                    </flux:button>
                @endif
            </div>
        </div>

        <!-- Bio & Profile Details Column -->
        <div class="md:col-span-2 space-y-6 md:pl-4">
            @if ($user->bio)
                <div class="space-y-2">
                    <flux:heading size="md" level="2" class="font-display font-bold text-zinc-800 dark:text-[#F3F1EA]">{{ __('Tentang Saya') }}</flux:heading>
                    <p class="text-zinc-600 dark:text-[#8D8D93] leading-relaxed text-sm whitespace-pre-line font-normal">{{ $user->bio }}</p>
                </div>
            @endif

            <!-- Main Skills -->
            @if (!empty($user->skills))
                <div class="space-y-2.5">
                    <flux:heading size="sm" level="3" class="font-mono text-zinc-400 dark:text-[#5B5D6B] uppercase tracking-widest text-[10px] font-semibold">{{ __('Keahlian Utama') }}</flux:heading>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($user->skills as $skill)
                            <flux:badge size="sm" variant="subtle" class="bg-[#D6A34E]/10 text-[#8A6A2A] dark:bg-[#D6A34E]/10 dark:text-[#D6A34E] border-none px-3 py-1 font-mono text-xs rounded-md">{{ $skill }}</flux:badge>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Contact & Social Information -->
            @if (!$user->hide_contact)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6 border-t border-zinc-200/60 dark:border-[#1F212B] text-xs text-zinc-500 dark:text-[#6E7080] font-medium">
                    @if ($user->email)
                        <div class="flex items-center gap-2.5 group">
                            <flux:icon name="envelope" class="size-4 text-zinc-400 group-hover:text-zinc-950 dark:group-hover:text-white transition-colors" />
                            <a href="mailto:{{ $user->email }}" class="hover:text-zinc-950 dark:hover:text-white transition-colors">{{ $user->email }}</a>
                        </div>
                    @endif

                    @if ($user->phone)
                        <div class="flex items-center gap-2.5">
                            <flux:icon name="phone" class="size-4 text-zinc-400" />
                            <span>{{ $user->phone }}</span>
                        </div>
                    @endif

                    @if ($user->github_url)
                        <div class="flex items-center gap-2.5 group">
                            <x-tech-icon name="github" class="size-4 opacity-70 group-hover:opacity-100 transition-opacity" />
                            <a href="{{ $user->github_url }}" target="_blank" class="hover:text-zinc-950 dark:hover:text-white transition-colors">
                                {{ preg_replace('/^https?:\/\/(www\.)?github\.com\//i', 'github.com/', $user->github_url) }}
                            </a>
                        </div>
                    @endif

                    @if ($user->linkedin_url)
                        <div class="flex items-center gap-2.5 group">
                            <x-tech-icon name="linkedin" class="size-4 opacity-70 group-hover:opacity-100 transition-opacity" />
                            <a href="{{ $user->linkedin_url }}" target="_blank" class="hover:text-zinc-950 dark:hover:text-white transition-colors">
                                {{ preg_replace('/^https?:\/\/(www\.)?linkedin\.com\/in\//i', 'linkedin.com/in/', $user->linkedin_url) }}
                            </a>
                        </div>
                    @endif

                    @if ($user->address)
                        <div class="flex items-center gap-2.5 sm:col-span-2">
                            <flux:icon name="map-pin" class="size-4 text-zinc-400 flex-shrink-0" />
                            <span>{{ $user->address }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Projects Section -->
    <section class="space-y-8">
        <!-- Section Header and Filters -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-zinc-200/60 dark:border-[#1F212B] pb-5">
            <div>
                <flux:heading size="lg" level="2" class="font-display font-bold tracking-tight text-[#17181C] dark:text-[#F3F1EA]">{{ __('Hasil Karya / Proyek') }}</flux:heading>
                <flux:subheading size="sm" class="text-zinc-400 dark:text-[#6E7080]">{{ __('Daftar proyek terpilih yang telah diselesaikan.') }}</flux:subheading>
            </div>
            
            <!-- Filters Bar -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 w-full md:w-auto">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari judul..." icon="magnifying-glass" size="sm" class="w-full sm:w-48 bg-white/50 dark:bg-[#14151B]" />
                
                <flux:select wire:model.live="category" size="sm" class="w-1/2 sm:w-36 bg-white/50 dark:bg-[#14151B]">
                    <option value="">Kategori</option>
                    <option value="Web Development">Web Development</option>
                    <option value="Mobile App Development">Mobile App Development</option>
                    <option value="Desktop Application">Desktop Application</option>
                    <option value="DevOps & Cloud">DevOps & Cloud</option>
                    <option value="Data Science & AI/ML">Data Science & AI/ML</option>
                    <option value="UI/UX Design">UI/UX Design</option>
                </flux:select>
                
                <flux:select wire:model.live="tech" size="sm" class="w-1/2 sm:w-36 bg-white/50 dark:bg-[#14151B]">
                    <option value="">Teknologi</option>
                    @foreach ($allTechs as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($projects as $project)
                <div 
                    wire:click="selectProject({{ $project->id }})" 
                    class="group cursor-pointer bg-white/50 dark:bg-[#14151B] border border-zinc-200/60 dark:border-[#1F212B] rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 hover:border-[#D6A34E]/30 dark:hover:border-[#D6A34E]/30 flex flex-col h-full"
                >
                    <!-- Project Cover Image -->
                    <div class="relative aspect-video w-full overflow-hidden bg-zinc-100 dark:bg-[#0A0B0F] border-b border-zinc-200/60 dark:border-[#1F212B]/60">
                        @if (!empty($project->images))
                            <img src="{{ asset('storage/' . $project->images[0]) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $project->title }}" />
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-zinc-400">
                                <flux:icon name="folder" class="size-10 stroke-1" />
                            </div>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-1.5">
                            <span class="font-mono text-[9px] font-bold text-zinc-400 dark:text-[#5B5D6B] tracking-widest uppercase">{{ $project->category }}</span>
                            <flux:heading size="md" level="3" class="font-display font-bold text-zinc-900 dark:text-white line-clamp-1 group-hover:text-[#D6A34E] dark:group-hover:text-[#D6A34E] transition-colors duration-200">{{ $project->title }}</flux:heading>
                        </div>

                        <!-- Top Tech Stack Chips -->
                        <div class="flex flex-wrap gap-1.5 pt-2">
                            @foreach (array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                <flux:badge size="sm" variant="subtle" class="text-[9px] bg-zinc-100 text-zinc-700 dark:bg-[#0A0B0F] dark:text-[#8D8D93] px-2 py-0.5 border-none flex items-center gap-1.5 rounded-md">
                                    <x-tech-icon :name="$tech" class="size-3" />
                                    <span>{{ $tech }}</span>
                                </flux:badge>
                            @endforeach
                            @if (count($project->tech_stack ?? []) > 3)
                                <flux:badge size="sm" variant="subtle" class="text-[9px] bg-zinc-100 text-zinc-700 dark:bg-[#0A0B0F] dark:text-[#8D8D93] px-2 py-0.5 border-none rounded-md">+{{ count($project->tech_stack) - 3 }}</flux:badge>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-zinc-400 italic bg-white/20 dark:bg-[#14151B]/50 rounded-xl border border-dashed border-zinc-200 dark:border-[#1F212B]">
                    {{ __('Tidak ada proyek yang sesuai dengan filter pencarian.') }}
                </div>
            @endforelse
        </div>
    </section>

    <!-- Project Detail Modal -->
    @if ($showModal && $selectedProject)
        <flux:modal wire:model="showModal" class="max-w-3xl bg-[#FAFAF8]/95 dark:bg-[#0A0B0F]/95 backdrop-blur-lg border border-zinc-200/60 dark:border-[#1F212B]">
            <div class="space-y-8">
                <!-- Action Header Links -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-200/60 dark:border-[#1F212B] pb-4 pr-10">
                    <div>
                        <span class="font-mono text-[9px] font-bold text-zinc-400 dark:text-[#5B5D6B] tracking-widest uppercase">{{ $selectedProject->category }}</span>
                        <flux:heading size="lg" level="2" class="font-display font-bold text-zinc-900 dark:text-white">{{ $selectedProject->title }}</flux:heading>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        @if ($selectedProject->project_url)
                            <flux:button href="{{ $selectedProject->project_url }}" target="_blank" size="sm" icon="arrow-top-right-on-square" class="shadow-sm !bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none font-semibold">
                                {{ __('Live Demo') }}
                            </flux:button>
                        @endif

                        @if ($selectedProject->github_url)
                            <flux:button href="{{ $selectedProject->github_url }}" target="_blank" size="sm" icon="folder">
                                {{ __('GitHub') }}
                            </flux:button>
                        @endif
                    </div>
                </div>

                <!-- Carousel Slider -->
                @if (!empty($selectedProject->images))
                    <div x-data="{ activeIndex: 0, total: {{ count($selectedProject->images) }} }" class="relative group">
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-zinc-100 dark:bg-[#14151B] border border-zinc-200/60 dark:border-[#1F212B] shadow-inner">
                            @foreach ($selectedProject->images as $index => $image)
                                <div x-show="activeIndex === {{ $index }}" class="w-full h-full">
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank" title="Lihat ukuran penuh">
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover" alt="{{ $selectedProject->title }}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Left / Right Slide Controls -->
                        @if (count($selectedProject->images) > 1)
                            <button @click="activeIndex = (activeIndex - 1 + total) % total" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black text-white rounded-full p-2 focus:outline-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm">
                                <flux:icon name="chevron-left" class="size-4" />
                            </button>
                            <button @click="activeIndex = (activeIndex + 1) % total" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black text-white rounded-full p-2 focus:outline-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 backdrop-blur-sm">
                                <flux:icon name="chevron-right" class="size-4" />
                            </button>

                            <!-- Indicators -->
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 bg-black/40 px-3 py-1.5 rounded-full backdrop-blur-sm">
                                @foreach ($selectedProject->images as $index => $image)
                                    <button @click="activeIndex = {{ $index }}" :class="activeIndex === {{ $index }} ? 'bg-[#D6A34E] scale-110' : 'bg-white/40'" class="size-1.5 rounded-full transition-all duration-250 focus:outline-none"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Tech Stack badges used in project -->
                @if (!empty($selectedProject->tech_stack))
                    <div class="space-y-3">
                        <flux:heading size="sm" level="3" class="font-mono text-zinc-400 dark:text-[#5B5D6B] uppercase tracking-widest text-[9px] font-bold">{{ __('Teknologi yang Digunakan') }}</flux:heading>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($selectedProject->tech_stack as $tech)
                                <flux:badge size="sm" variant="subtle" class="bg-[#D6A34E]/10 text-[#8A6A2A] dark:bg-[#D6A34E]/10 dark:text-[#D6A34E] border-none px-3.5 py-1.5 flex items-center gap-1.5 rounded-md text-xs font-mono">
                                    <x-tech-icon :name="$tech" class="size-3.5" />
                                    <span>{{ $tech }}</span>
                                </flux:badge>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description & Features -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-zinc-200/60 dark:border-[#1F212B] text-sm">
                    <!-- Project Features Bullet Points -->
                    <div class="space-y-3">
                        <flux:heading size="md" level="3" class="font-display font-bold text-[#17181C] dark:text-[#F3F1EA]">{{ __('Fitur-Fitur Utama') }}</flux:heading>
                        <ul class="space-y-2.5 text-zinc-600 dark:text-[#8D8D93]">
                            @foreach ($selectedProject->features as $feature)
                                <li class="flex items-start gap-2.5">
                                    <span class="text-[#D6A34E] font-extrabold mt-0.5">•</span>
                                    <span class="leading-relaxed">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Detailed Description -->
                    <div class="space-y-3">
                        <flux:heading size="md" level="3" class="font-display font-bold text-[#17181C] dark:text-[#F3F1EA]">{{ __('Deskripsi Proyek') }}</flux:heading>
                        <p class="text-zinc-600 dark:text-[#8D8D93] leading-relaxed whitespace-pre-line text-sm font-normal">
                            {{ $selectedProject->description ?: __('Tidak ada deskripsi detail tambahan untuk proyek ini.') }}
                        </p>
                    </div>
                </div>

                <!-- Footer close -->
                <div class="pt-4 border-t border-zinc-200/60 dark:border-[#1F212B] flex justify-end">
                    <flux:button wire:click="closeModal" class="px-5">{{ __('Tutup') }}</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
