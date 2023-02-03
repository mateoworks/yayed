<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function download(Document $document)
    {
        return Storage::disk('public')->download($document->url);
    }

    public function downloadWarranty(Warranty $warranty)
    {
        if ($warranty->url_document) {
            if (Storage::disk('public')->exists($warranty->url_document)) {
                return Storage::disk('public')->download($warranty->url_document);
            }
        }
        return;
    }
}
