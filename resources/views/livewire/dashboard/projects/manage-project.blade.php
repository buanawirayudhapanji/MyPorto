<div class="w-full space-y-6">
    <div class="border-b border-zinc-200/60 dark:border-[#1F212B] pb-4 flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1" class="font-display font-bold">{{ $isEdit ? __('Edit Proyek') : __('Tambah Proyek Baru') }}</flux:heading>
            <flux:subheading size="sm" class="text-zinc-400 dark:text-[#6E7080]">{{ __('Isi detail proyek di bawah ini dengan lengkap dan rapi.') }}</flux:subheading>
        </div>
        <flux:button href="{{ route('projects.index') }}" variant="ghost" icon="arrow-left" wire:navigate>
            {{ __('Kembali') }}
        </flux:button>
    </div>

    <form wire:submit="save" class="space-y-8 max-w-4xl bg-white/50 dark:bg-[#14151B] p-6 rounded-xl border border-zinc-200/60 dark:border-[#1F212B]">
        <!-- Title & Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:input wire:model="title" :label="__('Judul Proyek')" required placeholder="Aplikasi Portofolio Keren" class="bg-white/50 dark:bg-[#0A0B0F]" />

            <flux:select wire:model="category" :label="__('Kategori IT')" required class="bg-white/50 dark:bg-[#0A0B0F]">
                <option value="">-- Pilih Kategori --</option>
                <option value="Web Development">Web Development</option>
                <option value="Mobile App Development">Mobile App Development</option>
                <option value="Desktop Application">Desktop Application</option>
                <option value="DevOps & Cloud">DevOps & Cloud</option>
                <option value="Data Science & AI/ML">Data Science & AI/ML</option>
                <option value="Game Development">Game Development</option>
                <option value="Embedded Systems & IoT">Embedded Systems & IoT</option>
                <option value="Cybersecurity">Cybersecurity</option>
                <option value="UI/UX Design">UI/UX Design</option>
                <option value="Blockchain & Web3">Blockchain & Web3</option>
            </flux:select>
        </div>

        <!-- Tech Stack Searchable Dropdown UX -->
        <flux:field>
            <flux:label>{{ __('Komponen / Bahasa / Database yang Digunakan') }}</flux:label>
            <div class="relative" x-data="{ open: false }">
                <flux:input 
                    wire:model.live="tech_search" 
                    x-on:focus="open = true"
                    x-on:click.away="open = false"
                    wire:keydown.enter.prevent="addCustomTech"
                    placeholder="Ketik teknologi (contoh: Docker, Laravel, MySQL) dan enter..." 
                    class="bg-white/50 dark:bg-[#0A0B0F]"
                />

                @if(!empty($filtered_techs))
                    <div x-show="open" class="absolute z-50 w-full mt-1 bg-white dark:bg-[#14151B] border border-zinc-200/60 dark:border-[#1F212B] rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        @foreach($filtered_techs as $tech)
                            <button type="button" wire:click="addTech('{{ $tech }}')" class="w-full text-start px-4 py-2 hover:bg-zinc-100 dark:hover:bg-[#0A0B0F]/50 text-sm transition-colors duration-150 text-zinc-800 dark:text-[#F3F1EA] font-mono">
                                {{ $tech }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Chips -->
            <div class="flex flex-wrap gap-2 mt-3">
                @forelse($tech_stack as $index => $tech)
                    <flux:badge size="sm" class="flex items-center gap-1.5 bg-[#D6A34E]/10 text-[#8A6A2A] dark:text-[#D6A34E] border-none px-2.5 py-1 font-mono text-xs rounded-md">
                        <span>{{ $tech }}</span>
                        <button type="button" wire:click="removeTech({{ $index }})" class="text-[#8A6A2A] dark:text-[#D6A34E] hover:text-red-500 font-bold focus:outline-none text-xs ml-0.5">
                            &times;
                        </button>
                    </flux:badge>
                @empty
                    <flux:text class="text-xs text-zinc-400 dark:text-[#5B5D6B] italic font-mono">{{ __('Belum ada teknologi yang ditambahkan.') }}</flux:text>
                @endforelse
            </div>
            <flux:error name="tech_stack" />
        </flux:field>

        <!-- Features Bullet Points builder -->
        <flux:field>
            <flux:label>{{ __('Fitur-Fitur Utama Proyek') }}</flux:label>
            <div class="flex gap-2">
                <flux:input wire:model="new_feature" wire:keydown.enter.prevent="addFeature" placeholder="Tambah poin fitur baru..." class="flex-1 bg-white/50 dark:bg-[#0A0B0F]" />
                <flux:button type="button" wire:click="addFeature" class="!bg-[#D6A34E]/10 !text-[#8A6A2A] dark:!text-[#D6A34E] hover:!bg-[#D6A34E]/20 !border-none font-semibold">{{ __('Tambah') }}</flux:button>
            </div>

            <!-- List -->
            <ul class="mt-4 space-y-2 border border-zinc-200/60 dark:border-[#1F212B] rounded-lg p-4 bg-white/30 dark:bg-[#0A0B0F]/30">
                @forelse($features as $index => $feature)
                    <li class="flex items-start justify-between gap-3 text-sm text-zinc-700 dark:text-[#F3F1EA]">
                        <div class="flex items-start gap-2">
                            <span class="text-[#D6A34E] font-bold mt-0.5">•</span>
                            <span class="leading-relaxed">{{ $feature }}</span>
                        </div>
                        <button type="button" wire:click="removeFeature({{ $index }})" class="text-zinc-400 dark:text-[#5B5D6B] hover:text-red-500 font-medium text-xs focus:outline-none">
                            {{ __('Hapus') }}
                        </button>
                    </li>
                @empty
                    <flux:text class="text-xs text-zinc-400 dark:text-[#5B5D6B] italic font-mono">{{ __('Belum ada fitur yang ditambahkan.') }}</flux:text>
                @endforelse
            </ul>
            <flux:error name="features" />
        </flux:field>

        <!-- Description -->
        <flux:textarea wire:model="description" :label="__('Deskripsi Detail (Opsional)')" rows="5" placeholder="Berikan deskripsi detail tentang proyek ini..." class="bg-white/50 dark:bg-[#0A0B0F]" />

        <!-- Links & Status -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <flux:input wire:model="project_url" :label="__('Link Hasil Deploy / Unduh')" type="url" placeholder="https://example.com" class="bg-white/50 dark:bg-[#0A0B0F]" />
            <flux:input wire:model="github_url" :label="__('Link Repository GitHub')" type="url" placeholder="https://github.com/username/repo" class="bg-white/50 dark:bg-[#0A0B0F]" />
            
            <flux:select wire:model="status" :label="__('Status Proyek')" class="bg-white/50 dark:bg-[#0A0B0F]">
                <option value="draft">Draft (Simpan Dulu)</option>
                <option value="published">Publish (Tampilkan Publik)</option>
            </flux:select>
        </div>

        <!-- Drag & Drop Multi-Image Uploader -->
        <flux:field>
            <flux:label>{{ __('Gambar Proyek (Minimal 1, drag-and-drop didukung)') }}</flux:label>
            
            <div 
                x-data="{ dragging: false }"
                x-on:dragover.prevent="dragging = true"
                x-on:dragleave.prevent="dragging = false"
                x-on:drop.prevent="dragging = false; $upload('new_images', $event.dataTransfer.files, null, null, () => {})"
                :class="dragging ? 'border-[#D6A34E] bg-[#D6A34E]/[0.02]' : 'border-zinc-200/60 dark:border-[#1F212B] bg-transparent'"
                class="border-2 border-dashed rounded-xl p-8 text-center transition-colors duration-150 cursor-pointer relative"
            >
                <input 
                    type="file" 
                    wire:model="new_images" 
                    multiple 
                    accept="image/*" 
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                />
                
                <div class="space-y-2 pointer-events-none">
                    <flux:icon name="arrow-up-tray" class="size-8 mx-auto text-zinc-400 dark:text-[#5B5D6B]" />
                    <flux:text class="text-sm font-medium text-zinc-600 dark:text-[#8D8D93]">
                        {{ __('Klik untuk upload atau seret gambar ke sini') }}
                    </flux:text>
                    <flux:text class="text-xs text-zinc-400 dark:text-[#5B5D6B] font-mono">
                        {{ __('Maksimal 3MB per gambar.') }}
                    </flux:text>
                </div>
            </div>
            <flux:error name="images" />

            <!-- Sortable Image Preview List -->
            @if(count($images) > 0)
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($images as $index => $image)
                        <div class="group relative rounded-lg overflow-hidden border border-zinc-200/60 dark:border-[#1F212B] bg-zinc-50 dark:bg-[#0A0B0F] aspect-video flex flex-col justify-between">
                            <img src="{{ asset('storage/' . $image) }}" class="absolute inset-0 w-full h-full object-cover" alt="Project image" />
                            
                            <!-- Delete button -->
                            <button 
                                type="button" 
                                wire:click="removeImage({{ $index }})" 
                                class="absolute top-2 right-2 bg-black/60 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 focus:outline-none"
                            >
                                <flux:icon name="x-mark" class="size-4" />
                            </button>

                            <!-- Navigation buttons for reordering -->
                            <div class="absolute bottom-2 left-2 right-2 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                @if($index > 0)
                                    <button type="button" wire:click="moveImage({{ $index }}, 'left')" class="bg-black/60 hover:bg-black text-white rounded p-1 focus:outline-none">
                                        <flux:icon name="chevron-left" class="size-3.5" />
                                    </button>
                                @else
                                    <div></div>
                                @endif

                                @if($index < count($images) - 1)
                                    <button type="button" wire:click="moveImage({{ $index }}, 'right')" class="bg-black/60 hover:bg-black text-white rounded p-1 focus:outline-none">
                                        <flux:icon name="chevron-right" class="size-3.5" />
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </flux:field>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-zinc-200/60 dark:border-[#1F212B] flex justify-end">
            <flux:button type="submit" class="!bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none font-semibold shadow-[0_0_0_1px_rgba(214,163,78,0.15)]">{{ __('Simpan Proyek') }}</flux:button>
        </div>
    </form>
</div>
