<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Document;
use App\Models\Folder;
use App\Models\PasswordDoc;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Home extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $listeners = ['folderIdUpdated' => 'loadFolder',];

    // create new folder usage
    public $folders;
    public $folderId;
    public $currentFolder;
    public $breadcrumbs = [];
    public $folderName;
    public $isCreatingNewFolder = false;
    public $isRenamingFolder = false;
    public $folderBeingRenamed = null;

    public $newFolderName = '';
    public $selectedFolders = [];

    // checkbox usage
    public $selectedItems = [];
    public $selectedFiles = [];
    public $selectAll = false;

    // rename folder usage
    public $renamingFolderId = null;
    public $renamingFolderName = '';

    // show delete modal
    public $isModalOpen = false;
    public $isModalFileUpload = false;

    // searching usage
    public $search = '';
    public $searching = [];

    // alert
    public $success = false;

    public $userPermissions;
    public $parentPermissions = [];

    // download
    public $isDownload = false;
    public $passwordInput = '';
    public $errorDownloadMessages = '';

    // =============================== //
    // file usage
    public $file = [];

    public $isUploading = false;

    public $docs;

    public $isDropdown = false;
    public $perPage = 5;
    public $sortBy = 'created_at';
    public $sortDir = 'ASC';

    public function mount($folder = null)
    {
        $this->folderId = $folder;
        $this->loadFolder();
    }

    public function loadFolder()
    {
        if ($this->folderId) {
            $this->currentFolder = Folder::findOrFail($this->folderId);
            $this->generateBreadcrumbs($this->currentFolder);
        } else {
            $this->currentFolder = null;
            $this->breadcrumbs = [['name' => 'home', 'id' => null]];
        }
    }

    public function generateBreadcrumbs($folder)
    {
        $breadcrumbs = [];
        while ($folder) {
            array_unshift($breadcrumbs, ['name' => $folder->name, 'id' => $folder->id]);
            $folder = $folder->parent;
        }
        array_unshift($breadcrumbs, ['name' => 'home', 'id' => null]);
        $this->breadcrumbs = $breadcrumbs;
    }

    public function createFolder()
    {
        $this->isDropdown = false;
        $this->isCreatingNewFolder = true;
        $this->newFolderName = '';
        $folder = Folder::create([
            'name' => 'New Folder',
            'parent_id' => $this->folderId,
        ]);

        $this->loadFolder();
    }

    public function getHasSelectedItemsProperty()
    {
        return count($this->selectedItems) > 0;
    }
    public function getHasSelectedFilesProperty()
    {
        return count($this->selectedFiles) > 0;
    }

    public function checkIfAllSelected()
    {
        if (count($this->selectedItems) === Folder::count() || count($this->selectedFiles) === Document::count()) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function selectAllItem()
    {
        if ($this->selectAll) {
            // if count = 1 / root
            if(count($this->breadcrumbs) == 1)
            {
                // select all folder
                $this->selectedItems = Folder::pluck('id')->toArray();

                $this->selectedFiles = Document::where('folder_id', null)->paginate($this->perPage)->pluck('id')->toArray();

            // if count > 1 / not root
            } else {
                // get last id from breadcrumb
                $lastArr = end($this->breadcrumbs)['id'];
                $getSubfolder = Folder::where('id', $lastArr)->first();
                $this->selectedItems = $getSubfolder->where('parent_id', $getSubfolder->id)->pluck('id')->toArray();

                $this->selectedFiles = Document::where('folder_id', $lastArr)
                                                ->paginate($this->perPage)
                                                ->pluck('id')
                                                ->toArray();
            }
        } else {
            $this->selectedItems = [];
            $this->selectedFiles = [];
        }
    }

    public function deleteSelectedItems()
    {
        $folders = Folder::whereIn('id', $this->selectedItems)->get();
        foreach ($folders as $folder) {
            $this->deleteFolderWithPermissions($folder);
            $folderNames[] = $folder->name;
        }

        Folder::destroy($this->selectedItems);

        $documentNames = [];
        if($this->selectedFiles)
        {
            $documents = Document::whereIn('id', $this->selectedFiles)->get();
            foreach ($documents as $document) {
                $documentNames[] = $document->doc_name;
            }

            Document::destroy($this->selectedFiles);

            $docum = $documents->first();
            activity()
                ->causedBy(Auth::user())
                ->performedOn($documents->first())
                ->event('Delete')
                ->withProperties(['documents' => $documentNames])
                ->log(Auth::user()->name . ' Deleted Documents: ' . implode(', ', $documentNames));
        }

        $this->selectedItems = [];
        $this->selectedFiles = [];
        $this->selectAll = false;

        $doc = Folder::latest()->get();
        if ($doc->count() == 0) {
            $this->redirectRoute('home');
        }

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $this->isModalOpen = false;

        // just only for getting models name
        $folderName = $folders->first();
        if (!empty($folderNames)) {
            activity()
            ->causedBy(Auth::user())
            ->performedOn($folderName)
            ->event('Delete')
            ->withProperties(['folders' => $folderNames])
            ->log(Auth::user()->name . ' Deleted folders: ' . implode(', ', $folderNames));
        }

        session()->flash('success', 'Items has been deleted.');

        $this->dispatch('items-deleted');
    }

    private function deleteFolderWithPermissions($folder)
    {
        $children = Folder::where('parent_id', $folder->id)->get();
        foreach ($children as $child) {
            $this->deleteFolderWithPermissions($child);
        }

        $users = User::permission($folder->permission_name)->get();
        if($users)
        {
            foreach ($users as $user) {
                $user->revokePermissionTo($folder->permission_name);
            }
        }
        Permission::where('name', $folder->permission_name)->delete();
    }

    public function renameSelectedFolder()
    {
        if (count($this->selectedItems) == 1) {
            $this->isRenamingFolder = true;
            $this->folderBeingRenamed = $this->selectedItems[0];
            $folder = Folder::find($this->folderBeingRenamed);
            $this->newFolderName = $folder->name;
        } else {
            session()->flash('error', 'Please select only one folder to rename.');
        }
    }


    public function saveFolderName($folderId)
    {
        if (strlen($this->newFolderName) < 2) {
            session()->flash('error', 'Folder name must be at least 2 characters.');
            return;
        }

        $folder = Folder::findOrFail($folderId);

        if ($folder) {
            if ($this->isCreatingNewFolder) {

                try {
                    $folder->name = $this->newFolderName;
                    $folder->save();

                    activity()
                        ->causedBy(Auth::user())
                        ->performedOn($folder)
                        ->event('Create')
                        ->withProperties($folder->name)
                        ->log(Auth::user()->name . ' Created a Folder : ' . $folder->name);

                    session()->flash('success', 'Folder "' . $this->newFolderName . '" created successfully!');
                } catch (\Exception $e) {
                    \Log::error('Error creating folder: ' . $e->getMessage());
                    session()->flash('error', 'Create folder failed!');
                }

            } elseif ($this->isRenamingFolder) {

                try {
                    $folder->name = $this->newFolderName;
                    $folder->save();

                        activity()
                            ->causedBy(Auth::user())
                            ->performedOn($folder)
                            ->event('Rename')
                            ->withProperties($folder->name)
                            ->log(Auth::user()->name . ' Renamed a Folder : ' . $folder->name);
                    session()->flash('success', 'Folder renamed successfully!');
                } catch (\Exception $e) {
                    session()->flash('error', 'Rename folder failed!');
                }
            }

            $this->isCreatingNewFolder = false;
            $this->isRenamingFolder = false;
            $this->folderBeingRenamed = null;
            $this->loadFolder();
        }

        $this->loadFolder();
    }

    // =========================================================================================== //

    // file upload usage
    public function createFile()
    {
        try {

            $this->validate([
                'file.*' => 'file|mimes:docx,pdf|max:10240',
            ]);
            $fileNameArr = [];

            foreach($this->file as $file)
            {

                $fileName = $file->getClientOriginalName();
                $folderId = $this->folderId ? $this->folderId : null;
                $size = round($file->getSize() / (1024 * 1024), 2);

                $breadcrumbNames = collect($this->breadcrumbs)->pluck('name');

                $folderPath = $breadcrumbNames->count() > 1
                    ? $breadcrumbNames->slice(1)->implode('/')
                    : $breadcrumbNames->first();

                $path = $file->store("documents/{$folderPath}");

                $fileNameArr[] = $fileName;
                $document = Document::create([
                    'doc_name' => $fileName,
                    'path' => $path,
                    'folder_id' => $folderId,
                    'size' => $size,
                ]);
            }

            $this->isDropdown = false;
            $this->isModalFileUpload = false;
            $this->file = null;

            activity()
                ->causedBy(Auth::user())
                ->performedOn($document)
                ->event('Upload')
                ->withProperties(['name' => $fileNameArr])
                ->log(Auth::user()->name . ' Uploaded a file : ' . $fileNameArr);

            session()->flash('success', 'File uploaded successfully!');

            $this->dispatch('items-deleted');
        } catch (\Exception $e) {
            $this->isModalFileUpload = false;
            $this->file = null;
            session()->flash('error', 'An error occurred while uploading the file: ' . $e->getMessage());
        }
    }

    public function finish()
    {
        $this->redirect('/home/'.$this->folderId);
    }

    public function downloadModal()
    {
        $this->isDownload = true;
    }

    public function download()
    {
        $validPassword = PasswordDoc::get()->first();
        if($this->passwordInput == $validPassword->password)
        {
            $document = Document::findOrFail($this->selectedFiles)->first();

            activity()
                ->causedBy(Auth::user())
                ->performedOn($document)
                ->event('Download')
                ->withProperties($document->doc_name)
                ->log(Auth::user()->name . ' Downloaded a file : ' . $document->doc_name);

            $this->isDownload = false;

            if(Storage::disk('local')->exists($document->path)){
                $this->errorDownloadMessages = '';
                $this->passwordInput = '';
                return Storage::download($document->path, $document->doc_name);
            }

            session()->flash('success', 'File successfully downloaded!');
        } else {
            $this->errorDownloadMessages = 'Password invalid, Please try again !';
        }
    }

    public function closeDownloadModal()
    {
        $this->errorDownloadMessages = '';
        $this->passwordInput = '';
        $this->isDownload = false;
    }

    public function resetModal()
    {
        $this->isModalFileUpload = false;
        $this->file = null;
    }


    public function updatedSearch()
    {
        $user = Auth::user();
        $permissionFolder = [
            'Design' => ['Drawing', 'Manual Book', 'Standard', 'Design', 'Workshop'],
            'Workshop' => ['Drawing', 'Manual Book', 'Standard', 'Workshop'],
            'Maintenance' => ['Drawing', 'Manual Book', 'Standard', 'Maintenance'],
        ];

        if ($user->hasRole('Design')) {
            $accessFolder = $permissionFolder['Design'];
        } elseif ($user->hasRole('Workshop')) {
            $accessFolder = $permissionFolder['Workshop'];
        } elseif ($user->hasRole('Maintenance')) {
            $accessFolder = $permissionFolder['Maintenance'];
        } else {
            $accessFolder = [];
        }

        $parentFolderId = Folder::whereIn('name', $accessFolder)->pluck('id')->toArray();

        function getAllDescendantFolderIds(array $folderIds) {
            $allFolderIds = $folderIds;

            foreach ($folderIds as $folderId) {
                $parentId = Folder::where('parent_id', $folderId)->pluck('id')->toArray();
                $allFolderIds = array_merge($allFolderIds, getAllDescendantFolderIds($parentId));
            }

            return $allFolderIds;
        }

        $idFolder = getAllDescendantFolderIds($parentFolderId);

        if ($user->hasAnyRole(['Design', 'Workshop', 'Maintenance'])) {
            if (strlen($this->search) >= 1) {
                $this->searching = Document::whereIn('folder_id', $idFolder)
                    ->where('doc_name', 'like', '%' . $this->search . '%')
                    ->limit(3)
                    ->get();
            } else {
                $this->searching = [];
            }
        } else {
            if (strlen($this->search) >= 1) {
                $this->searching = Document::where('doc_name', 'like', '%' . $this->search . '%')
                    ->get();
            } else {
                $this->searching = [];
            }
        }

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
        $user = Auth::user();

        if($user->hasRole('Admin')) {

            $location = end($this->breadcrumbs)['id'];
            $folder = Folder::where('id', $location)->first();
            (count($this->breadcrumbs) > 1)
                ?  $documents = Document::where('folder_id', $folder->id)->paginate($this->perPage)
                : $documents = Document::where('folder_id', null)->paginate($this->perPage);

            $this->folders = Folder::where('parent_id', $this->folderId)
            ->orderBy($this->sortBy, $this->sortDir)
            ->latest()
            ->get();
        }
        else
        {
            $location = end($this->breadcrumbs)['id'];
            $document= Folder::where('id', $location)->first();

            $this->userPermissions = $user->permissions->pluck('name');
            $folders = Folder::whereIn('permission_name', $this->userPermissions)->get(); // drawing

            $this->folders = Folder::where('parent_id', $this->folderId)
                ->orderBy($this->sortBy, $this->sortDir)
                ->latest()
                ->get();

                (count($this->breadcrumbs) > 1)
                ? $documents = Document::where('folder_id', $document->id)->paginate($this->perPage) // whereclause
                : $documents = Document::where('folder_id', null)->paginate($this->perPage);
        }
        return view('livewire.home', [
            'folders' => $this->folders,
            'documents' => $documents,
            'searching' => $this->searching,
            'search' => $this->search,
        ]);
    }

}
