<section class="space-y-8">
    <header class="flex flex-col gap-4 rounded-3xl border border-white/10 bg-[#140f0c]/80 p-6 shadow-2xl shadow-black/20 backdrop-blur xl:flex-row xl:items-end xl:justify-between">
        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#f0a56f]">The Grapes admin area</p>
            <h1 class="font-serif text-4xl font-bold tracking-tight text-white sm:text-5xl">Manage shows and socials from one place.</h1>
            <p class="max-w-3xl text-sm leading-6 text-[#d7c5b3] sm:text-base">
                Signed-in users can use this area to add upcoming shows, update their order, and keep the band’s social profiles current.
            </p>
        </div>

        <div class="grid gap-3 sm:grid-cols-3 xl:min-w-[28rem]">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <div class="text-2xl font-bold text-white">{{ $this->shows->count() }}</div>
                <div class="mt-1 text-xs uppercase tracking-[0.18em] text-[#d7c5b3]">Shows</div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <div class="text-2xl font-bold text-white">{{ $this->socialLinks->count() }}</div>
                <div class="mt-1 text-xs uppercase tracking-[0.18em] text-[#d7c5b3]">Social links</div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <div class="text-2xl font-bold text-white">Admin</div>
                <div class="mt-1 text-xs uppercase tracking-[0.18em] text-[#d7c5b3]">Verified access</div>
            </div>
        </div>
    </header>

    <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <article id="show-form" class="rounded-3xl border border-white/10 bg-[#15100d]/90 p-6 shadow-2xl shadow-black/20">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-white">{{ $editingShowId ? 'Edit show' : 'Add a new show' }}</h2>
                    <p class="mt-1 text-sm text-[#d7c5b3]">Create upcoming dates, set the order, and mark featured performances.</p>
                </div>

                @if ($editingShowId)
                    <button type="button" wire:click="resetShowForm" class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/5">
                        Cancel
                    </button>
                @endif
            </div>

            <form wire:submit.prevent="saveShow" class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-white" for="showTitle">Show title</label>
                    <input id="showTitle" type="text" wire:model="showTitle" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="Friday Night Live" />
                    @error('showTitle') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="showVenue">Venue</label>
                    <input id="showVenue" type="text" wire:model="showVenue" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="The Cellar" />
                    @error('showVenue') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="showDate">Date</label>
                    <input id="showDate" type="date" wire:model="showDate" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-[#f0a56f] focus:outline-none" />
                    @error('showDate') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="showTime">Time</label>
                    <input id="showTime" type="time" wire:model="showTime" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-[#f0a56f] focus:outline-none" />
                    @error('showTime') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="showTicketUrl">Ticket URL</label>
                    <input id="showTicketUrl" type="url" wire:model="showTicketUrl" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="https://" />
                    @error('showTicketUrl') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="showSortOrder">Sort order</label>
                    <input id="showSortOrder" type="number" min="0" wire:model="showSortOrder" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-[#f0a56f] focus:outline-none" />
                    @error('showSortOrder') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-white" for="showDescription">Description</label>
                    <textarea id="showDescription" wire:model="showDescription" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="Add event notes, support acts, or booking details."></textarea>
                    @error('showDescription') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2 flex flex-wrap items-center gap-4 rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                    <label class="flex items-center gap-2 text-sm text-white">
                        <input type="checkbox" wire:model="showFeatured" class="rounded border-white/20 bg-white/10 text-[#f0a56f] focus:ring-[#f0a56f]" />
                        Featured show
                    </label>
                    <label class="flex items-center gap-2 text-sm text-white">
                        <input type="checkbox" wire:model="showPublished" class="rounded border-white/20 bg-white/10 text-[#f0a56f] focus:ring-[#f0a56f]" />
                        Publish to site
                    </label>
                </div>

                <div class="sm:col-span-2 flex items-center gap-3 pt-2">
                    <button type="submit" class="rounded-full bg-gradient-to-r from-[#ffb15c] to-[#d15f2f] px-5 py-3 text-sm font-semibold text-[#1b110b] shadow-lg shadow-[#d15f2f]/20 transition hover:-translate-y-0.5">
                        {{ $editingShowId ? 'Update show' : 'Save show' }}
                    </button>
                    <button type="button" wire:click="resetShowForm" class="rounded-full border border-white/10 px-5 py-3 text-sm font-medium text-white transition hover:bg-white/5">
                        Reset
                    </button>
                </div>
            </form>
        </article>

        <article id="social-form" class="rounded-3xl border border-white/10 bg-[#15100d]/90 p-6 shadow-2xl shadow-black/20">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-white">{{ $editingSocialId ? 'Edit social link' : 'Update socials' }}</h2>
                    <p class="mt-1 text-sm text-[#d7c5b3]">Keep booking and social links current without touching the homepage code.</p>
                </div>

                @if ($editingSocialId)
                    <button type="button" wire:click="resetSocialForm" class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/5">
                        Cancel
                    </button>
                @endif
            </div>

            <form wire:submit.prevent="saveSocial" class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="socialPlatform">Platform</label>
                    <input id="socialPlatform" type="text" wire:model="socialPlatform" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="Instagram" />
                    @error('socialPlatform') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="socialLabel">Label</label>
                    <input id="socialLabel" type="text" wire:model="socialLabel" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="@thegrapesband" />
                    @error('socialLabel') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-white" for="socialUrl">URL</label>
                    <input id="socialUrl" type="url" wire:model="socialUrl" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="https://instagram.com/thegrapesband" />
                    @error('socialUrl') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="socialIcon">Icon name</label>
                    <input id="socialIcon" type="text" wire:model="socialIcon" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-[#f0a56f] focus:outline-none" placeholder="instagram" />
                    @error('socialIcon') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white" for="socialSortOrder">Sort order</label>
                    <input id="socialSortOrder" type="number" min="0" wire:model="socialSortOrder" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-[#f0a56f] focus:outline-none" />
                    @error('socialSortOrder') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                    <label class="flex items-center gap-2 text-sm text-white">
                        <input type="checkbox" wire:model="socialIsActive" class="rounded border-white/20 bg-white/10 text-[#f0a56f] focus:ring-[#f0a56f]" />
                        Show on site
                    </label>
                </div>

                <div class="sm:col-span-2 flex items-center gap-3 pt-2">
                    <button type="submit" class="rounded-full bg-gradient-to-r from-[#ffb15c] to-[#d15f2f] px-5 py-3 text-sm font-semibold text-[#1b110b] shadow-lg shadow-[#d15f2f]/20 transition hover:-translate-y-0.5">
                        {{ $editingSocialId ? 'Update social' : 'Save social' }}
                    </button>
                    <button type="button" wire:click="resetSocialForm" class="rounded-full border border-white/10 px-5 py-3 text-sm font-medium text-white transition hover:bg-white/5">
                        Reset
                    </button>
                </div>
            </form>
        </article>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <article id="shows-list" class="rounded-3xl border border-white/10 bg-[#15100d]/90 p-6 shadow-2xl shadow-black/20">
            <div class="mb-5 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-white">Upcoming shows</h2>
                    <p class="mt-1 text-sm text-[#d7c5b3]">Review, edit, or remove upcoming dates.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($this->shows as $show)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-base font-semibold text-white">{{ $show->title }}</h3>
                                    @if ($show->is_featured)
                                        <span class="rounded-full bg-[#f0a56f]/20 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#ffcf9e]">Featured</span>
                                    @endif
                                    <span class="rounded-full bg-white/10 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#d7c5b3]">
                                        {{ $show->is_published ? 'Published' : 'Hidden' }}
                                    </span>
                                </div>

                                <p class="text-sm text-[#d7c5b3]">{{ $show->venue }} · {{ $show->event_date->format('M j, Y') }}@if ($show->event_time) · {{ substr($show->event_time, 0, 5) }}@endif</p>

                                @if ($show->description)
                                    <p class="max-w-3xl text-sm leading-6 text-[#bfae9f]">{{ $show->description }}</p>
                                @endif

                                @if ($show->ticket_url)
                                    <a href="{{ $show->ticket_url }}" target="_blank" class="inline-flex text-sm font-medium text-[#ffcf9e] underline decoration-[#ffcf9e]/40 underline-offset-4">Ticket link</a>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-2 lg:justify-end">
                                <button type="button" wire:click="editShow({{ $show->id }})" class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/5">Edit</button>
                                <button type="button" wire:click="deleteShow({{ $show->id }})" wire:confirm="Delete this show?" class="rounded-full border border-red-400/20 px-4 py-2 text-sm font-medium text-red-200 transition hover:bg-red-500/10">Delete</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-white/15 bg-white/5 p-6 text-sm text-[#d7c5b3]">
                        No shows yet. Add the first date using the form above.
                    </div>
                @endforelse
            </div>
        </article>

        <article id="socials-list" class="rounded-3xl border border-white/10 bg-[#15100d]/90 p-6 shadow-2xl shadow-black/20">
            <div class="mb-5 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-white">Social links</h2>
                    <p class="mt-1 text-sm text-[#d7c5b3]">Keep your public profiles and booking links aligned.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($this->socialLinks as $socialLink)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-base font-semibold text-white">{{ $socialLink->platform }}</h3>
                                    @if ($socialLink->label)
                                        <span class="rounded-full bg-white/10 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#d7c5b3]">{{ $socialLink->label }}</span>
                                    @endif
                                    <span class="rounded-full bg-white/10 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#d7c5b3]">
                                        {{ $socialLink->is_active ? 'Visible' : 'Hidden' }}
                                    </span>
                                </div>

                                <a href="{{ $socialLink->url }}" target="_blank" class="break-all text-sm font-medium text-[#ffcf9e] underline decoration-[#ffcf9e]/40 underline-offset-4">{{ $socialLink->url }}</a>
                            </div>

                            <div class="flex flex-wrap gap-2 lg:justify-end">
                                <button type="button" wire:click="editSocial({{ $socialLink->id }})" class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/5">Edit</button>
                                <button type="button" wire:click="deleteSocial({{ $socialLink->id }})" wire:confirm="Delete this social link?" class="rounded-full border border-red-400/20 px-4 py-2 text-sm font-medium text-red-200 transition hover:bg-red-500/10">Delete</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-white/15 bg-white/5 p-6 text-sm text-[#d7c5b3]">
                        No social links yet. Add Instagram, Facebook, YouTube, or booking links above.
                    </div>
                @endforelse
            </div>
        </article>
    </div>

    <script>
        (() => {
            if (window.__grapesDashboardScrollBound) {
                return;
            }

            window.__grapesDashboardScrollBound = true;

            const scrollToDashboardSection = (event) => {
                const targetId = event.detail?.target;

                if (!targetId) {
                    return;
                }

                requestAnimationFrame(() => {
                    const targetElement = document.getElementById(targetId);

                    if (!targetElement) {
                        return;
                    }

                    targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });

                    const focusTarget = targetElement.querySelector('input, textarea, button');

                    if (focusTarget instanceof HTMLElement) {
                        focusTarget.focus({ preventScroll: true });
                    }
                });
            };

            window.addEventListener('scroll-to-dashboard-section', scrollToDashboardSection);
        })();
    </script>
</section>