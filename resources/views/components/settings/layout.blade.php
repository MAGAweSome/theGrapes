<div class="settings-surface flex items-start max-md:flex-col text-white">
    <style>
        .settings-surface label,
        .settings-surface h1,
        .settings-surface h2,
        .settings-surface h3,
        .settings-surface h4,
        .settings-surface h5,
        .settings-surface h6,
        .settings-surface p,
        .settings-surface a,
        .settings-surface .text-sm,
        .settings-surface .text-base,
        .settings-surface .text-lg {
            color: #f5efe6 !important;
        }

        .settings-surface .text-[#d7c5b3],
        .settings-surface .text-[#e8dfd5] {
            color: #f5efe6 !important;
        }

        .settings-surface input,
        .settings-surface textarea {
            color: #555 !important;
            caret-color: #555 !important;
            -webkit-text-fill-color: #555 !important;
        }

        .settings-surface [data-flux-control],
        .settings-surface [data-flux-control] input,
        .settings-surface [data-flux-control] textarea {
            color: #555 !important;
            caret-color: #555 !important;
            -webkit-text-fill-color: #555 !important;
        }

        .settings-surface input::placeholder,
        .settings-surface textarea::placeholder,
        .settings-surface [data-flux-control]::placeholder,
        .settings-surface input[data-flux-control]::placeholder,
        .settings-surface textarea[data-flux-control]::placeholder {
            color: #555 !important;
            opacity: 1 !important;
        }
    </style>

    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item class="!text-[#e8dfd5] hover:!text-white" :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item class="!text-[#e8dfd5] hover:!text-white" :href="route('security.edit')" wire:navigate>{{ __('Security') }}</flux:navlist.item>
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
