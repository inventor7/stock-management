<?php

namespace App\Http\Controllers;

use App\Models\BonAcompte;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use function Spatie\LaravelPdf\Support\pdf;

class PdfController extends Controller
{
    public function bonAcomptePdf(BonAcompte $record)
    {
        $pdfContent = Browsershot::html('<h1>Hello world</h1>')
            ->setIncludePath(config('services.browsershort.include_path'))
            ->savePdf('accompte.pdf');
    }
}
