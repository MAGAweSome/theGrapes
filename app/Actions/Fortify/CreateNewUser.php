<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        $name = Str::of($input['name'])
            ->squish()
            ->lower()
            ->title()
            ->toString();

        $email = Str::of($input['email'])
            ->trim()
            ->lower()
            ->toString();

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $input['password'],
        ]);
    }
}
