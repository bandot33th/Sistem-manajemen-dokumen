<?php

namespace App\Livewire;

use App\Models\PasswordDoc;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PassDocs extends Component
{
    #[Validate('required|min:8')]
    public $password;

    public function save()
    {
        try {
            $this->validate([
                'password' => 'required|min:8',
            ]);

            $password = PasswordDoc::get()->first()->update(['password' => $this->password]);
            session()->flash('success', 'Password has been updated.');
            return redirect()->to('/passDocs');

        } catch (\Exception $e) {
            $this->reset('password');
            session()->flash('error', 'The password must be at least 8 characters.');
            return;
        }

    }

    public function render()
    {
        $passwordDoc = PasswordDoc::get()->first();
        return view('livewire.passDocs',
        [
            'passwordDoc' => $passwordDoc
        ]);
    }
}
