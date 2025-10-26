<?php

namespace App\DTOs;

class QuotationTotals
{
    public function __construct(
        public readonly float $subtotal,
        public readonly float $taxRate,
        public readonly float $taxAmount,
        public readonly float $totalAmount
    ) {}

    public static function create(
        float $subtotal,
        float $taxRate,
        float $taxAmount,
        ?float $totalAmount = null
    ): self {
        return new self(
            subtotal: $subtotal,
            taxRate: $taxRate,
            taxAmount: $taxAmount,
            totalAmount: $totalAmount
        );
    }

    public function toArray(): array
    {
        return [
            'subtotal' => $this->subtotal,
            'tax_rate' => $this->taxRate,
            'tax_amount' => $this->taxAmount,
            'total_amount' => $this->totalAmount,
        ];
    }
}
