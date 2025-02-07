<?php

namespace App\Livewire\Users;

use App\Models\Folder;
use Livewire\Component;

class UserAccess extends Component
{

    public $selectedRoles = [];

    public function updatedSelectedFolders()
    {
        $this->emit('folderSelected', $this->selectedRoles);
    }

    public function render()
    {
        $folders = Folder::where('parent_id', null)->with('children')->get();
        return view('livewire.users.user-access', [
            'folders' => $folders
        ]);
    }
}
