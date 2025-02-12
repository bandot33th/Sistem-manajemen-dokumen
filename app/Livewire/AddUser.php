<?php

namespace App\Livewire;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddUser extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $department = '';
    public $role;

    public $selectedRoles = [];
    public $roles = [];
    public $adminRoleId = 1;

    public function mount() //buat ngambil data di dalam role databae
    {
        $this->roles = Role::all();
    }

    public function updatedSelectedRoles()
    {
        if (in_array($this->adminRoleId, $this->selectedRoles)) {
            $this->selectedRoles = [$this->adminRoleId];
        }
    }

    public function addUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'selectedRoles' => 'required|array|min:1',
        ]);
        try {

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'department' => $this->department,
            ]);

            $user->assignRole(Role::whereIn('id', $this->selectedRoles)->pluck('name')->toArray());

            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->event('Create')
                ->withProperties($user->name)
                ->log(Auth::user()->name . ' Created new User : ' . $user->name);

            session()->flash('success', 'User successfully created.');
            $this->redirect('/addUser');
        } catch (\Exception $e) {
            session()->flash('error', 'User creation failed!');
            $this->reset();
            $this->redirect('/addUser');
            return;
        }
    }

    public function render()
    {
        return view('livewire.addUser',
        [
            'roles' => $this->roles,
        ]);
    }
}
