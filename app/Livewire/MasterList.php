<?php

namespace App\Livewire;

use App\Models\CategoryMasterList;
use App\Models\MasterList as ModelsMasterList;
use Livewire\Component;
use App\Exports\MasterlistExport;
use App\Imports\MasterlistImport;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class MasterList extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $masterlistData;

    public $drawing_number = 0;
    public $address;
    public $machineName;
    public $fileContent;
    public $remarks;
    public $category;
    public $slug;

    public $selectedItem;
    public $isEdit = false;
    public $isView = false;
    public $isUploaded = false;
    public $isDropdown = false;

    public $query = 0;
    public $title = 'Show All';

    public $file;

    public $perPage = 10;
    public $sortBy = 'updated_at';
    public $sortDir = 'ASC';

    public $details = '';

    public function save()
    {
        switch ($this->category) {
            case 1:
                $address = 'MD-' . $this->address;
                break;
            case 2:
                $address = 'ED-' . $this->address;
                break;
            case 3:
                $address = 'CD-' . $this->address;
                break;
            case 4:
                $address = 'UD-' . $this->address;
                break;
            default:
                $address = 'MD-' . $this->address;
                break;
        }

        $slug = $this->address . '-' . $this->machineName;

        $masterlist = ModelsMasterList::where('slug', $slug)
            ->where('category_master_list_id', $this->category)
            ->orderBy('id', 'desc') 
            ->first();


        if ($masterlist) {
            $this->drawing_number = $masterlist->drawing_number + 1;
        } else {
            $this->drawing_number = 1;
        }

        try {
            $masterlist = ModelsMasterList::create([
                'drawing_number' => $this->drawing_number,
                'address_of_drawing' => $address,
                'name_of_machine' => $this->machineName,
                'drawing_file_contents' => $this->fileContent,
                'remarks' => $this->remarks,
                'category_master_list_id' => $this->category,
                'slug' => $slug,
            ]);

            session()->flash('success', 'Masterlist created successfully.');
            $this->reset();
        } catch (\Exception $e) {
            session()->flash('error', 'Masterlist could not be created.');
        }
        $this->dispatch('masterlistCreated');
    }

    public function selectForEdit($id)
    {
        $this->selectedItem = $id;
        $item = ModelsMasterList::find($this->selectedItem);
        $this->address = $item->address_of_drawing;
        $this->machineName = $item->name_of_machine;
        $this->fileContent = $item->drawing_file_contents;
        $this->remarks = $item->remarks;
        $this->slug = $item->slug;
        $this->category = $item->category_master_list_id;

        $this->isEdit = true;
    }

    public function edit()
    {
        try {
            $masterlist = ModelsMasterList::find($this->selectedItem);
            $masterlist->update([
                'address_of_drawing' => $this->address,
                'name_of_machine' => $this->machineName,
                'drawing_file_contents' => $this->fileContent,
                'remarks' => $this->remarks,
                'slug' => $this->slug,
                'category_master_list_id' => $this->category,
            ]);

            session()->flash('success', 'Update successfully.');
            $this->reset();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update.');
        }
    }

    public function close()
    {
        $this->isEdit = false;
        $this->isView = false;
        $this->reset();
    }

    public function export($category)
    {
        $categoryId = CategoryMasterList::where('name', $category)->first()->id;
        return Excel::download(new MasterlistExport($categoryId), 'masterlist-' . strtolower($category) . '.xlsx');
    }

    public function import()
    {
        foreach ($this->file as $file) {
            $filePath = $file->store('imports/masterlist');
            Excel::import(new MasterlistImport(), $filePath);
        }

        return redirect('/masterList')->with('success', 'File has been imported');
    }

    public function finish()
    {
        $this->redirect('/masterList');
    }

    public function queryTab($query)
    {
        $this->query = $query;
        switch ($this->query) {
            case 0:
                $this->title = 'Show All';
                break;
            case 1:
                $this->title = 'Mechanic';
                break;
            case 2:
                $this->title = 'Electric';
                break;
            case 3:
                $this->title = 'Civil';
                break;
            case 4:
                $this->title = 'Utility';
                break;
            default:
                $this->title = 'Show All';
                break;
        }

        $this->isDropdown = false;
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = $this->sortDir == 'ASC' ? 'DESC' : 'ASC';
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function viewDetails($id)
    {
        $this->selectedItem = $id;
        $this->details = ModelsMasterList::findOrFail($this->selectedItem);
        // $this->address = $item->address_of_drawing;
        // $this->machineName = $item->name_of_machine;
        // $this->fileContent = $item->drawing_file_contents;
        // $this->remarks = $item->remarks;
        // $this->slug = $item->slug;
        // $this->category = $item->category_master_list_id;

        $this->isView = true;
    }

    public function render()
    {
        if ($this->query >= 1) {
            return view('livewire.masterList', [
                'masterlist' => ModelsMasterList::with('category')
                    ->where('category_master_list_id', $this->query)
                    ->orderBy($this->sortBy, $this->sortDir)
                    ->paginate($this->perPage),
                'category_list' => CategoryMasterList::all(),
                'details' => $this->details,
            ]);
        } else {
            return view('livewire.masterList', [
                'masterlist' => ModelsMasterList::with('category')
                    ->orderBy($this->sortBy, $this->sortDir)
                    ->paginate($this->perPage),
                'category_list' => CategoryMasterList::all(),
                'details' => $this->details,
            ]);
        }
    }
}
