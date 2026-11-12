<x-layouts::auth :title="__('Accept Invitation')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Accept Invitation')" :description="__('Complete your account setup to join The Grapes.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.invite.store', $invite->token) }}" class="flex flex-col gap-6">
            @csrf
            
            <!-- Email Address (Readonly) -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="$invite->email"
                type="email"
                disabled
            />

            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Password -->
            <div x-data="{
                password: '',
                get strength() {
                    let score = 0;
                    if (this.password.length >= 8) score += 1;
                    if (/[A-Z]/.test(this.password) && /[a-z]/.test(this.password)) score += 1;
                    if (/[0-9]/.test(this.password)) score += 1;
                    if (/[^A-Za-z0-9]/.test(this.password)) score += 1;
                    return score;
                },
                get color() {
                    if (this.strength === 0) return 'bg-zinc-700';
                    if (this.strength <= 1) return 'bg-red-500';
                    if (this.strength === 2) return 'bg-yellow-500';
                    if (this.strength === 3) return 'bg-blue-500';
                    return 'bg-green-500';
                },
                get label() {
                    if (this.strength === 0) return '';
                    if (this.strength <= 1) return 'Weak';
                    if (this.strength === 2) return 'Fair';
                    if (this.strength === 3) return 'Good';
                    return 'Strong';
                }
            }">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                    x-model="password"
                />
                
                <div class="mt-2 flex items-center gap-2" x-show="password.length > 0" x-cloak>
                    <div class="flex-1 h-1.5 rounded-full bg-zinc-700 overflow-hidden">
                        <div class="h-full transition-all duration-300" :class="color" :style="`width: ${(strength / 4) * 100}%`"></div>
                    </div>
                    <span class="text-xs font-medium" :class="{'text-red-400': strength <= 1, 'text-yellow-400': strength === 2, 'text-blue-400': strength === 3, 'text-green-400': strength === 4}" x-text="label"></span>
                </div>
            </div>

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>
