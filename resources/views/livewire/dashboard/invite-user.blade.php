<div>
    <header class="mb-10">
        <h1 class="text-3xl font-bold text-white">Invite a User</h1>
        <p class="mt-2 text-[#d7c5b3]">Send an invitation email to allow a new band member to register.</p>
    </header>
    <div class="mt-10 rounded-3xl border border-white/10 bg-[#15100d]/90 p-6 shadow-2xl shadow-black/20">
        <form wire:submit.prevent="invite" class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <div class="flex-1">
                <flux:input wire:model="email" type="email" label="Email Address" placeholder="member@example.com" required />
            </div>
            <flux:button type="submit" variant="primary">Send Invite</flux:button>
        </form>
    </div>
</div>
