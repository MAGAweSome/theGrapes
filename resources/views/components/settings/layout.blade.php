<div class="settings-surface flex items-start max-md:flex-col text-white">

    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item class="!text-[#e8dfd5] hover:!text-white" :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item class="!text-[#e8dfd5] hover:!text-white" :href="route('security.edit')">{{ __('Security') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading class="text-white">{{ $heading ?? '' }}</flux:heading>
        <flux:subheading class="text-[#d7c5b3]">{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
