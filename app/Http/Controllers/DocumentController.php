<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MasterlistImport;

use Illuminate\Http\JsonResponse;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Storage;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class DocumentController extends Controller
{
    public function index()
    {
        return view('uploads.upload');
    }
    public function view($filename)
    {
        $docs = Document::where('path', 'like', '%' .  $filename)->first();
        $filePath = storage_path('app/private/' . $docs->path);
        $pdfData = base64_encode(file_get_contents($filePath));

        activity()
            ->causedBy(Auth::user())
            ->performedOn($docs)
            ->event('View')
            ->withProperties($docs->doc_name)
            ->log(Auth::user()->name . ' View a file');

        return view('livewire.documents.view', ['data' => $pdfData]);
    }


    public function uploadMasterlist(Request $request)
    {
        if($request->hasFile('file')){

            $file = $request->file('file');
            $filePath = $file->store('imports/masterlist');
            try {
                Excel::import(new MasterlistImport, $filePath);
                return response()->json(['success' => 'File uploaded successfully']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'File processing failed: ' . $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function upload(Request $request)
    {
        if($request->hasFile('file')){
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $size = $file->getSize();
        $sizeInMegabytes = round($size / (1024 * 1024), 2);

        $folderId = ($request->input('folderId')) ? $request->input('folderId') : null;
        $breadcrumbs = json_decode($request->input('breadcrumbs'), true);

        $breadcrumbNames = collect($breadcrumbs)->pluck('name');
        $folderPath = $breadcrumbNames->count() > 1
                    ? $breadcrumbNames->slice(1)->implode('/')
                    : $breadcrumbNames->first();

        $path = $file->store("documents/{$folderPath}");
        Document::create([
            'folder_id' => $folderId,
            'doc_name' => $originalName,
            'path' => $path,
            'size' => $sizeInMegabytes,
        ]);
        $document = Document::where('path', $path)->first();
        activity()
            ->causedBy(Auth::user())
            ->performedOn($document)
            ->event('Upload')
            ->withProperties(['uploaded_file' => $originalName])
            ->log(Auth::user()->name . ' Uploaded a file: ' . $originalName);
        return response()->json(['success' => 'File Uploaded Successfully']);
    } else
        {
            return response()->json(['error' => 'File upload failed.']);
        }
    }
}
