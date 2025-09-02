<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Create User')]
class UserCreateComponent extends Component
{
    public $name;
    public $email;
    public $password;
    public bool $is_admin;

    public function mount($is_admin = false)
    {
        $this->is_admin = $is_admin;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'is_admin' => 'boolean',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->is_admin = $validated['is_admin'];
        $user->save();
        session()->flash('success', 'User created successfully.');
        $this->redirectRoute('admin.users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.user.user-create-component');
    }
}
