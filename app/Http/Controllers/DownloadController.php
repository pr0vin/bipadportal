<?php

namespace App\Http\Controllers;

use App\Download;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'document_name' => 'required',
            'document' => 'required',
        ]);

        $data['document'] = $request->file('document')->store('downloads');
        Download::create($data);

        return redirect()->back()->with('success', "New document uploaded");
    }

    public function delete(Download $download)
    {
        $download->delete();

        return redirect()->route('settings.document')->with('success', "Selected document removed");
    }

    public function downloadUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'document_name' => 'required',
            'document' => 'nullable',
        ]);
        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('downloads');
        }

        Download::find($id)->update($data);

        return redirect()->route('settings.document')->with('success','Selected download updated');
    }
}
