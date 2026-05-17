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

            <div class="auth-surface relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
                <style>
                    .auth-surface [data-flux-label],
                    .auth-surface label,
                    .auth-surface h1,
                    .auth-surface h2,
                    .auth-surface h3,
                    .auth-surface h4,
                    .auth-surface h5,
                    .auth-surface h6,
                    .auth-surface p,
                    .auth-surface a,
                    .auth-surface span,
                    .auth-surface .text-sm,
                    .auth-surface .text-base,
                    .auth-surface .text-lg,
                    .auth-surface .text-xs {
                        color: #f5efe6 !important;
                    }

                    .auth-surface input,
                    .auth-surface textarea,
                    .auth-surface [data-flux-control],
                    .auth-surface [data-flux-control] * {
                        color: #111 !important;
                        caret-color: #111 !important;
                        -webkit-text-fill-color: #111 !important;
                    }

                    .auth-surface input::placeholder,
                    .auth-surface textarea::placeholder,
                    .auth-surface [data-flux-control]::placeholder {
                        color: #555 !important;
                        opacity: 1 !important;
                    }
                </style>

                <div class="mb-6 flex w-full max-w-md items-center justify-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-3 shadow-2xl shadow-black/20 backdrop-blur-xl" wire:navigate>
                        <x-app-logo class="h-8" />
                    </a>
                </div>

                <div class="w-full max-w-md rounded-[2rem] border border-white/10 bg-[#15100d]/90 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-8">
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
