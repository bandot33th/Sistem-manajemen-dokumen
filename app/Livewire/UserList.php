<?php

namespace App\Livewire;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    use WithPagination;

    // modal
    public $isModalOpen = false;
    public $isEdit = false;
    public $userAccess = false;

    public $selectedUser;

    // edit usage
    public $name;
    public $email;
    public $password;
    public $userEdit = '';

    public $selectedRoles = [];
    public $roles = [];
    public $folders = [];

    // searching usage
    public $search = '';

    public $perPage = 5;
    public $sortBy = 'updated_at';
    public $sortDir = 'ASC';

    public function mount() //buat ngambil data di dalam role databae
    {
        $this->roles = Role::all();
        $this->folders = Folder::where('parent_id', null)->with('children')->get();
    }
    // when click button delete
    public function selectedItem($id)
    {
        $this->selectedUser = $id;
        $this->isModalOpen = true;
    }
    public function delete()
    {
        $user = User::find($this->selectedUser);
        $user->delete();

        $this->isModalOpen = false;
        $this->selectedUser = null;

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('Delete')
            ->withProperties($user->name)
            ->log(Auth::user()->name . ' Deleted User : ' . Auth::user()->name);

        session()->flash('success', 'User deleted.');
        $this->dispatch('items-deleted');
    }

    // when click button edit
    public function selectForEdit($id)
    {
        $user = User::find($id);

        $this->selectedUser = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';

        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->isEdit = true;
    }

    public function openUserAccess()
    {
        $this->isEdit = false;
        $this->userAccess = true;
    }
    public function goBackToEditModal()
    {
        $this->isEdit = true;
        $this->userAccess = false;
    }

    public function edit()
    {
        $user = User::find($this->selectedUser);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->reset();
    }

    public function submitAccess()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'selectedRoles' => 'required|array|min:1', // Ensures at least one role is selected
        ]);
        try {
            $user = User::find($this->selectedUser);

            // Sync roles for the user
            $user->syncRoles(Role::whereIn('id', $this->selectedRoles)->pluck('name')->toArray());

            if (!empty($this->password)) {
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password)
                ]);
            } else {
                unset($this->password);
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
            }

            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->event('Edit')
                ->withProperties($user->name)
                ->log(Auth::user()->name . ' Edit selected user');

            session()->flash('success', 'User updated : ' . Auth::user()->name);
            $this->reset();
        } catch (\Exception $e) {
            $this->isEdit = false;
            $this->userAccess = false;
            session()->flash('error', $e->getMessage());
            $this->reset();
            return;
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isEdit = false;
        $this->userAccess = false;
        $this->selectedRoles = [];
    }

    public function setSortBy($sortByField) {

        if($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? "DESC" : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        $users = User::with('permissions')
                        ->search($this->search)
                        ->orderBy($this->sortBy, $this->sortDir)
                        ->paginate($this->perPage);

        return view('livewire.userList',
        [
            'users' => $users,
            'roles' => $this->roles,
            'userEdit' => $this->userEdit,
        ]);
    }
}
