<?php

namespace App\Services;

use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;

class QuotationPDFGenerator
{
    protected string $view = 'pdf.quotation';

    protected array $paperConfig = [
        'format' => 'a4',
        'orientation' => 'portrait'
    ];

    public function generate(Quotation $quotation): PDF
    {
        $data = $this->prepareData($quotation);

        return $this->createPDF($data);
    }

    public function download(Quotation $quotation, ?string $filename = null): Response {
        $pdf = $this->generate($quotation);
        $filename = $filename ?? $this->generateFilename($quotation);
        return $pdf->download($filename);
    }

    protected function prepareData(Quotation $quotation): array
    {
        $quotation->load([
            'project.customer',
            'lines.solarPanel'
        ]);

        return [
            'quotation' => $quotation,
            'project' => $quotation->project,
            'customer' => $quotation->project->customer,
            'lines' => $this->prepareLines($quotation),
            'totals' => $this->calculateTotals($quotation),
        ];
    }

    protected function prepareLines(Quotation $quotation): array
    {
        return $quotation->lines()
            ->orderBy('sort_order')
            ->get()
            ->map(function ($line) {
                return [
                    'description' => $this->getLineDescription($line),
                    'quantity' => $line->quantity,
                    'unit_price' => $line->unit_price,
                    'discount_percentage' => $line->discount_percentage,
                    'discount_amount' => $line->discount_amount,
                    'line_total' => $line->line_total,
                    'notes' => $line->notes,
                ];
            })
            ->toArray();
    }

    protected function getLineDescription($line): string
    {
        if ($line->description) {
            return $line->description;
        }

        if ($line->solarPanel) {
            return "{$line->solarPanel->manufacturer} {$line->solarPanel->model} - {$line->solarPanel->wattage}W";
        }

        return 'N/A';
    }

    protected function calculateTotals(Quotation $quotation): array
    {
        return [
            'subtotal' => $quotation->subtotal,
            'tax_rate' => $quotation->tax_rate,
            'tax_amount' => $quotation->tax_amount,
            'discount_amount' => $quotation->discount_amount,
            'total_amount' => $quotation->total_amount,
        ];
    }

    protected function createPDF(array $data): PDF
    {
        return FacadePdf::loadView($this->view, $data)
            ->setPaper($this->paperConfig['format'], $this->paperConfig['orientation'])
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans');
    }

    public function generateFilename(Quotation $quotation): string
    {
        $number = $quotation->quotation_number ?? $quotation->id;
        $date = $quotation->quotation_date?->format('Y-m-d') ?? now()->format('Y-m-d');

        return "quotation-{$number}-{$date}.pdf";
    }
}
