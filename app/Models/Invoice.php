<?php

namespace App\Models;

use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',

        'seller_name',
        'seller_address',
        'seller_gstin',
        'seller_pan',

        'customer_name',
        'customer_address',
        'customer_gstin',
        'customer_pan',

        'place_of_supply',
        'country_of_supply',

        'subtotal',
        'discount',
        'taxable_amount',
        'cgst',
        'sgst',
        'total',
        'early_payment_discount',
        'final_amount',

        'account_name',
        'account_number',
        'ifsc',
        'bank_name',
        'account_type',
        'upi',

        'notes'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}