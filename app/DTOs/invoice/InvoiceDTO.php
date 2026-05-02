<?php

namespace App\DTOs\Invoice;

use Carbon\Carbon;

class InvoiceDTO
{
    public function __construct(
        public string $invoice_number,
        public Carbon $invoice_date,
        public Carbon $due_date,

        public array $seller,
        public array $customer,
        public array $supply,
        public array $amounts,
        public array $payment_details,

        public ?string $notes,
        public array $items
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            invoice_number: $data['invoice_number'],
            invoice_date: Carbon::parse($data['invoice_date']),
            due_date: Carbon::parse($data['due_date']),

            seller: $data['seller'],
            customer: $data['customer'],
            supply: $data['supply'],
            amounts: $data['amounts'],
            payment_details: $data['payment_details'],

            notes: $data['notes'] ?? null,
            items: $data['items']
        );
    }

    public function toArray(): array
    {
        return [
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,

            'seller_name' => $this->seller['name'],
            'seller_address' => $this->seller['address'],
            'seller_gstin' => $this->seller['gstin'] ?? null,
            'seller_pan' => $this->seller['pan'] ?? null,

            'customer_name' => $this->customer['name'],
            'customer_address' => $this->customer['address'],
            'customer_gstin' => $this->customer['gstin'] ?? null,
            'customer_pan' => $this->customer['pan'] ?? null,

            'place_of_supply' => $this->supply['place_of_supply'] ?? null,
            'country_of_supply' => $this->supply['country_of_supply'] ?? null,

            'subtotal' => $this->amounts['subtotal'],
            'discount' => $this->amounts['discount'],
            'taxable_amount' => $this->amounts['taxable_amount'],
            'cgst' => $this->amounts['cgst'],
            'sgst' => $this->amounts['sgst'],
            'total' => $this->amounts['total'],
            'early_payment_discount' => $this->amounts['early_payment_discount'] ?? null,
            'final_amount' => $this->amounts['final_amount'] ?? null,

            'account_name' => $this->payment_details['account_name'] ?? null,
            'account_number' => $this->payment_details['account_number'] ?? null,
            'ifsc' => $this->payment_details['ifsc'] ?? null,
            'bank_name' => $this->payment_details['bank_name'] ?? null,
            'account_type' => $this->payment_details['account_type'] ?? null,
            'upi' => $this->payment_details['upi'] ?? null,

            'notes' => $this->notes,
        ];
    }

    public function items(): array
    {
        return $this->items;
    }
}