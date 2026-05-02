<?php
namespace App\Services\Invoice;

use App\DTOs\Invoice\InvoiceDTO;
use App\Models\Invoice;

class InvoiceService
{
    public function create(InvoiceDTO $dto): Invoice
    {
        $invoice = Invoice::create($dto->toArray());

        $items = collect($dto->items())->map(function ($item) {
            return [
                'description'    => $item['description'],
                'hsn'            => $item['hsn'] ?? null,
                'quantity'       => $item['quantity'],
                'gst_percent'    => $item['gst_percent'],
                'taxable_amount' => $item['taxable_amount'],
                'cgst'           => $item['cgst'],
                'sgst'           => $item['sgst'],
                'total_amount'   => $item['total_amount'],
            ];
        })->toArray();

        $invoice->items()->createMany($items);

        return $invoice;
    }

}
