<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

use App\Models\Activity as ModelsActivity;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityExport;

class Activity extends Component
{
    use WithPagination;

    public $isView = false;
    public $isDelete = false;

    public $activity = '';
    public $selectedItem;

    public $properties;

    public $perPage = 5;
    public $sortBy = 'updated_at';
    public $sortDir = 'ASC';

    public $search = '';


    public function selectDelete($id)
    {
        $this->selectedItem = $id;
        $this->isDelete = true;
    }

    public function delete()
    {
        try {
            $item = ModelsActivity::findOrFail($this->selectedItem);
            $item->delete();

            $this->isDelete = false;
            $this->selectedItem = null;

            session()->flash('success', 'Item has been deleted.');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting the item');
        }
    }

    public function getProperties($activity)
    {
        switch (class_basename($activity->subject_type)) {
            case 'Document':
                return Document::find($activity->subject_id);
            case 'Folder':
                return Folder::find($activity->subject_id);
            case 'User':
                return User::find($activity->subject_id);
            default:
                return null;
        }
    }

    public function viewDetail($id)
    {
        $this->isView = true;
        $this->activity = ModelsActivity::with(['causer', 'subject'])->find($id);
        $this->properties = $this->getProperties($this->activity);
    }

    public function closeModal()
    {
        $this->isView = false;
    }
    public function export()
    {
        return Excel::download(new ActivityExport, 'activities.xlsx');
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
        return view('livewire.activity',
        [
             'activities' => ModelsActivity::with(['causer', 'subject'])
                                            ->search($this->search)
                                            ->orderBy($this->sortBy, $this->sortDir)
                                            ->paginate($this->perPage)
        ]);
    }
}
