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
            <!-- Header/Navigation (Minimalist) -->
            <header class="flex items-center justify-between pb-6 border-b border-zinc-200/60 dark:border-[#1F212B] mb-12">
                <a href="/" class="text-lg font-display font-bold tracking-tight text-[#17181C] dark:text-[#F3F1EA] flex items-center gap-2">
                    <span class="size-7 rounded-md bg-[#D6A34E] flex items-center justify-center text-[#0A0B0F] font-mono font-bold text-sm">P</span>
                    <span>MyPorto</span>
                </a>
                
                <!-- Appearance/Theme Toggle -->
                <div class="flex items-center gap-4">
                    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" size="sm">
                        <flux:radio value="light" icon="sun" />
                        <flux:radio value="dark" icon="moon" />
                        <flux:radio value="system" icon="computer-desktop" />
                    </flux:radio.group>
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="mt-20 pt-8 border-t border-zinc-200 dark:border-[#1F212B] text-center font-mono text-xs text-zinc-400 dark:text-[#5B5D6B]">
                <p>&copy; {{ date('Y') }} MyPorto. All rights reserved.</p>
            </footer>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
