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

            ::selection { background: #D6A34E; color: #0A0B0F; }
        </style>

        <!-- Ambient Background Glow (single, restrained) -->
        <div class="absolute inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 left-1/2 -translate-x-1/2 size-[700px] rounded-full bg-[#D6A34E]/[0.06] dark:bg-[#D6A34E]/[0.08] blur-[140px]"></div>
        </div>

        <div class="bg-transparent flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-display font-bold" wire:navigate>
                    <span class="size-9 rounded-md bg-[#D6A34E] flex items-center justify-center text-[#0A0B0F] font-mono font-bold text-base shadow-sm">P</span>
                    <span class="text-lg tracking-tight text-[#17181C] dark:text-[#F3F1EA]">{{ config('app.name', 'MyPorto') }}</span>
                </a>
                <div class="flex flex-col gap-6 mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
