@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="My Porto" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-[#D6A34E] text-[#0A0B0F]">
            <span class="font-mono font-bold text-sm">P</span>
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="My Porto" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-[#D6A34E] text-[#0A0B0F]">
            <span class="font-mono font-bold text-sm">P</span>
        </x-slot>
    </flux:brand>
@endif
