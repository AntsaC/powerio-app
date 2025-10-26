<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Services\QuotationPDFGenerator;
use Illuminate\Http\Response;

class QuotationController extends Controller
{
    protected QuotationPDFGenerator $pdfGenerator;

    public function __construct(QuotationPDFGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function downloadPDF(Quotation $quotation): Response
    {
        return $this->pdfGenerator->download($quotation);
    }
}
