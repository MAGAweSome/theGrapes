<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#060504] antialiased text-white" x-data="{ sitePreviewOpen: false }" @keydown.escape.window="sitePreviewOpen = false">
        <div class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(209,95,47,0.28),_transparent_36%),radial-gradient(circle_at_top_right,_rgba(240,165,111,0.12),_transparent_32%),linear-gradient(135deg,_#060504_0%,_#120d0a_42%,_#1b120d_100%)]">
            <div class="pointer-events-none absolute inset-0 opacity-70">
                <div class="absolute left-[-6rem] top-16 h-72 w-72 rounded-full bg-[#d15f2f]/20 blur-3xl"></div>
                <div class="absolute bottom-[-7rem] right-[-5rem] h-80 w-80 rounded-full bg-[#f0a56f]/12 blur-3xl"></div>
            </div>

            <div class="relative z-10 flex min-h-screen flex-col">
                <header class="border-b border-white/10 bg-black/20 backdrop-blur-xl">
                    <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-6 py-4 lg:px-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3" wire:navigate>
                            <x-app-logo class="h-9" />
                        </a>

                        <div class="flex items-center gap-3">
                            <flux:button variant="ghost" size="sm" class="cursor-pointer !text-white hover:!text-white hover:bg-white/10" type="button" @click="sitePreviewOpen = true">
                                {{ __('View site') }}
                            </flux:button>

                            <flux:dropdown position="bottom" align="end">
                                <flux:profile
                                    :initials="auth()->user()->initials()"
                                    icon-trailing="chevrons-up-down"
                                    class="border border-white/10 bg-white/5 text-white"
                                />

                                <flux:menu>
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm text-black">
                                        <flux:avatar
                                            :name="auth()->user()->name"
                                            :initials="auth()->user()->initials()"
                                        />

                                        <div class="grid flex-1 text-start text-sm leading-tight text-black">
                                            <flux:heading class="truncate text-black">{{ \Illuminate\Support\Str::title(auth()->user()->name) }}</flux:heading>
                                            <flux:text class="truncate text-black">{{ auth()->user()->email }}</flux:text>
                                        </div>
                                    </div>

                                    <flux:menu.separator />

                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                                            {{ __('Settings') }}
                                        </flux:menu.item>

                                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                                            @csrf
                                            <flux:menu.item
                                                as="button"
                                                type="submit"
                                                icon="arrow-right-start-on-rectangle"
                                                class="w-full cursor-pointer"
                                                data-test="logout-button"
                                            >
                                                {{ __('Log out') }}
                                            </flux:menu.item>
                                        </form>
                                    </flux:menu.radio.group>
                                </flux:menu>
                            </flux:dropdown>
                        </div>
                    </div>
                </header>

                <main class="mx-auto flex w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        <div
            x-cloak
            x-show="sitePreviewOpen"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 px-4 py-6 backdrop-blur-sm"
            @click.self="sitePreviewOpen = false"
        >
            <div class="relative flex h-[92vh] w-full max-w-7xl flex-col overflow-hidden rounded-3xl border border-white/10 bg-[#0b0908] shadow-2xl shadow-black/60">
                <div class="flex items-center justify-between gap-4 border-b border-white/10 px-4 py-3 sm:px-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#f0a56f]">Site preview</p>
                        <p class="text-sm text-[#d7c5b3]">Live view of the public homepage while you stay on the dashboard.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:button variant="ghost" size="sm" class="cursor-pointer !text-white hover:!text-white hover:bg-white/10" type="button" @click="document.getElementById('grapes-site-preview').contentWindow.location.reload()">
                            {{ __('Refresh') }}
                        </flux:button>

                        <flux:button variant="ghost" size="sm" class="cursor-pointer !text-white hover:!text-white hover:bg-white/10" type="button" @click="sitePreviewOpen = false">
                            {{ __('Close') }}
                        </flux:button>
                    </div>
                </div>

                <iframe
                    id="grapes-site-preview"
                    src="{{ route('home') }}"
                    title="{{ __('Public site preview') }}"
                    class="h-full w-full bg-white"
                ></iframe>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
