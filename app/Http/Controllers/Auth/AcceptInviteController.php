<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserInvite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class AcceptInviteController extends Controller
{
    public function show($token)
    {
        $invite = UserInvite::where('token', $token)->whereNull('completed_at')->firstOrFail();
        return view('auth.accept-invite', ['invite' => $invite]);
    }

    public function store(Request $request, $token)
    {
        $invite = UserInvite::where('token', $token)->whereNull('completed_at')->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $invite->email,
            'password' => Hash::make($request->password)
        ]);

        $invite->update(['completed_at' => now()]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
