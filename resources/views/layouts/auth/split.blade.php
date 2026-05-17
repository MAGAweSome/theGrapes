<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#060504] antialiased text-white">
        <div class="relative min-h-screen overflow-x-hidden bg-[radial-gradient(circle_at_top_left,_rgba(209,95,47,0.28),_transparent_36%),radial-gradient(circle_at_top_right,_rgba(240,165,111,0.14),_transparent_32%),linear-gradient(135deg,_#060504_0%,_#120d0a_42%,_#1b120d_100%)]">
            <div class="pointer-events-none absolute inset-0 opacity-70">
                <div class="absolute left-[-6rem] top-16 h-72 w-72 rounded-full bg-[#d15f2f]/20 blur-3xl"></div>
                <div class="absolute bottom-[-7rem] right-[-5rem] h-80 w-80 rounded-full bg-[#f0a56f]/12 blur-3xl"></div>
            </div>

            <div class="relative z-10 grid min-h-screen lg:grid-cols-2">
                <div class="relative hidden overflow-hidden border-e border-white/10 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <div class="absolute inset-0 bg-black/20 backdrop-blur-sm"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(240,165,111,0.18),_transparent_40%),linear-gradient(135deg,_rgba(13,10,8,0.88),_rgba(24,18,14,0.72))]"></div>

                    <a href="{{ route('home') }}" class="relative z-20 inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-3 shadow-2xl shadow-black/20 backdrop-blur-xl" wire:navigate>
                        <x-app-logo class="h-8" />
                    </a>

                    @php
                        [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                    @endphp

                    <div class="relative z-20 max-w-lg rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#f0a56f]">The Grapes</p>
                        <blockquote class="mt-4 space-y-3">
                            <flux:heading size="lg" class="text-white">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                            <footer><flux:heading class="text-[#d7c5b3]">{{ trim($author) }}</flux:heading></footer>
                        </blockquote>
                    </div>
                </div>

                <div class="flex items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
                    <div class="w-full max-w-md space-y-6">
                        <a href="{{ route('home') }}" class="flex justify-center lg:hidden" wire:navigate>
                            <x-app-logo class="h-8" />
                        </a>
                        <div class="rounded-[2rem] border border-white/10 bg-[#15100d]/90 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-8">
                            {{ $slot }}
                        </div>
                    </div>
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
