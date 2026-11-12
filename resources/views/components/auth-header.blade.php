@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <!-- <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#f0a56f]">The Grapes</p> -->
    <flux:heading size="xl" class="mt-3 text-white">{{ $title }}</flux:heading>
    <flux:subheading class="mt-2 text-[#d7c5b3]">{{ $description }}</flux:subheading>
</div>
