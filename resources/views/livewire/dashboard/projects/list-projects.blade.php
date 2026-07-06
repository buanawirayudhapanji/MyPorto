<div class="w-full space-y-6">
    <div class="flex items-center justify-between border-b border-zinc-200/60 dark:border-[#1F212B] pb-4">
        <div>
            <flux:heading size="xl" level="1" class="font-display font-bold">{{ __('My Projects') }}</flux:heading>
            <flux:subheading size="sm" class="text-zinc-400 dark:text-[#6E7080]">{{ __('Kelola semua proyek dan hasil pekerjaan Anda.') }}</flux:subheading>
        </div>
        <flux:button href="{{ route('projects.create') }}" icon="plus" class="!bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none font-semibold shadow-[0_0_0_1px_rgba(214,163,78,0.15)]" wire:navigate>
            {{ __('Tambah Proyek') }}
        </flux:button>
    </div>

    <!-- Filters Section -->
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari judul proyek..." icon="magnifying-glass" class="bg-white/50 dark:bg-[#14151B]" />
        </div>
        <div class="w-full sm:w-48">
            <flux:select wire:model.live="status" class="bg-white/50 dark:bg-[#14151B]">
                <option value="">Semua Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </flux:select>
        </div>
    </div>

    <!-- Table of Projects -->
    <div class="bg-white/50 dark:bg-[#14151B] rounded-xl border border-zinc-200/60 dark:border-[#1F212B] overflow-hidden">
        <flux:table>
            <flux:table.columns>
                <flux:table.column class="w-[35%] !ps-6">{{ __('Proyek') }}</flux:table.column>
                <flux:table.column class="w-[20%]">{{ __('Kategori') }}</flux:table.column>
                <flux:table.column class="w-[25%]">{{ __('Teknologi') }}</flux:table.column>
                <flux:table.column class="w-[10%]">{{ __('Status') }}</flux:table.column>
                <flux:table.column class="w-[10%] text-end !pe-6">{{ __('Aksi') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($projects as $project)
                    <flux:table.row :key="$project->id">
                        <flux:table.cell class="!ps-6">
                            <div class="flex items-center gap-3">
                                @if (count($project->images) > 0)
                                    <img src="{{ asset('storage/' . $project->images[0]) }}" class="size-10 rounded-lg object-cover border border-zinc-200/60 dark:border-[#1F212B]/60" alt="{{ $project->title }}" />
                                @else
                                    <div class="size-10 rounded-lg bg-zinc-100 dark:bg-[#0A0B0F] flex items-center justify-center border border-zinc-200/60 dark:border-[#1F212B]/60">
                                        <flux:icon name="folder" class="size-5 text-zinc-400" />
                                    </div>
                                @endif
                                <div class="font-display font-semibold text-zinc-900 dark:text-[#F3F1EA]">
                                    {{ $project->title }}
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="text-xs font-medium text-zinc-500 dark:text-[#8D8D93]">{{ $project->category }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-wrap gap-1 max-w-xs">
                                @foreach (array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                    <flux:badge size="sm" variant="subtle" class="text-[9px] bg-[#D6A34E]/10 text-[#8A6A2A] dark:text-[#D6A34E] border-none px-2 py-0.5 flex items-center gap-1 font-mono rounded-md">
                                        <x-tech-icon :name="$tech" class="size-3" />
                                        <span>{{ $tech }}</span>
                                    </flux:badge>
                                @endforeach
                                @if (count($project->tech_stack ?? []) > 3)
                                    <flux:badge size="sm" variant="subtle" class="text-[9px] bg-zinc-100 text-zinc-700 dark:bg-[#0A0B0F] dark:text-[#8D8D93] border-none px-2 py-0.5 rounded-md font-mono">+{{ count($project->tech_stack) - 3 }}</flux:badge>
                                @endif
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if ($project->status === 'published')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-200/30 dark:border-emerald-800/30">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-800/40 dark:text-zinc-400 border border-zinc-200/30 dark:border-zinc-800/30">
                                    Draft
                                </span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell class="text-end !pe-6">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button href="{{ route('projects.edit', $project->id) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                <flux:button wire:click="deleteProject({{ $project->id }})" wire:confirm="Apakah Anda yakin ingin menghapus proyek ini?" size="sm" variant="ghost" icon="trash" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center py-8 text-zinc-400 dark:text-[#5B5D6B] italic font-mono text-xs">
                            {{ __('Belum ada proyek yang ditambahkan atau tidak ada hasil pencarian.') }}
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>

    @if ($projects->hasPages())
        <div class="pt-4">
            {{ $projects->links() }}
        </div>
    @endif
</div>
