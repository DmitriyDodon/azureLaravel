<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    public function saveFile(Request $request)
    {
        $data = $request->validate([
            'file' => 'file|required|max:10240',
            'is_private' => Rule::in('on', null)
        ]);

        if (isset($data['is_private'])) {
            $result = Storage::disk('azure_private')->put($data['file']->getClientOriginalName(), $data['file']->get(), 'private');
            if ($result) {
                //проблема с апи по этому нужно через SAS
                return Storage::disk('azure_private')->url($data['file']->getClientOriginalName()). '?' .env('AZURE_STORAGE_SAS_TOKEN');
            }
        }

        $result = Storage::disk('azure')->put($data['file']->getClientOriginalName(), $data['file']->get() , 'public');
        if ($result) {
            return Storage::disk('azure')->url($data['file']->getClientOriginalName());
        }

        return back()->withErrors(['message' => 'Uploading failed']);
    }
}
