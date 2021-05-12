<?php

namespace App\Http\Controllers;

use App\Models\Link;
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
                $link = Storage::disk('azure_private')->url($data['file']->getClientOriginalName());
                $tempLink = Link::where('link', $link)->first();
                if (empty($tempLink)) { //there is no such link
                    $linkParams = [
                        'link' => $link,
                        'temp_link' => env('HOST_NAME') . '/' . LinkController::generateRandomString(10),
                        'created_at' => now(),
                        'dead_at' => now()->addMinutes(10),
                    ];
                    $link = Link::create($linkParams);
                    return $link->temp_link;

                }else{//there is such link
                    return $tempLink->temp_link;
                }














                //проблема с апи по этому нужно через SAS
//                return Storage::disk('azure_private')->url($data['file']->getClientOriginalName()). '?' .env('AZURE_STORAGE_SAS_TOKEN');
            }
        }

        $result = Storage::disk('azure')->put($data['file']->getClientOriginalName(), $data['file']->get(), 'public');
        if ($result) {
            return Storage::disk('azure')->url($data['file']->getClientOriginalName());
        }

        return back()->withErrors(['message' => 'Uploading failed']);
    }
}
