<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    private $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->middleware('auth');
        $this->documentService = $documentService;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $document = $this->documentService->find($request->id);
        $this->documentService->unlinkDocument($document);
        $document->delete();

        return $request->wantsJson() 
            ? response()->json(['status'=> 200, 'message'=> 'Deleted Successfully'])
            : redirect()->back()->with('success', 'Document has been deleted.');
    }
}
