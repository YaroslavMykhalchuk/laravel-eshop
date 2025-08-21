<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class RegisterComponent extends Component
{
    public string $name;
    public string $email;
    public string $password;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6|max:255',
        ]);
        $user = User::query()->create($validated);

        session()->flash('success', 'Thanks for registration!');
        $this->redirectRoute('login', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.register-component', [
            'title' => 'Register',
        ]);
    }
}
