<?php
namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\UserInvite;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitationMail;
use Flux\Flux;

class InviteUser extends Component
{
    public $email = '';

    public function invite()
    {
        $this->validate(['email' => 'required|email|unique:users,email']);
        
        $invite = UserInvite::updateOrCreate(
            ['email' => $this->email],
            ['token' => Str::random(60)]
        );
        
        Mail::to($this->email)->send(new UserInvitationMail($invite));
        
        \Flux::toast('Invitation sent successfully.', 'success');
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.dashboard.invite-user');
    }
}
