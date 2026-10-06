<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoice = Invoice::latest()->get();

        return view(
            'invoice.index',
            compact('invoice')
        );
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);

        $pdf = Pdf::loadView(
            'invoice.pdf',
            compact('invoice')
        );

        return $pdf->download(
            $invoice->nomor_invoice . '.pdf'
        );
    }
}