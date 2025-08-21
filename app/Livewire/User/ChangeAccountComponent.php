<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class ChangeAccountComponent extends Component
{
    public string $name;
    public string $email;
    public string $password = '';

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function save()
    {
        $user = User::query()->findOrFail(auth()->id());
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|min:6|max:255',
        ]);
        if(!$validated['password']) {
            unset($validated['password']);
        }
        $user->update($validated);

        session()->flash('success', 'Account details updated successfully!');
        $this->redirectRoute('login', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.change-account-component', [
            'title' => 'Change Account',
        ]);
    }
}
