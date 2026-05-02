<?php

namespace App\Http\Requests;

use App\DTOs\Invoice\InvoiceDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class InvoiceRequest extends FormRequest
{
    public InvoiceDTO $data;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Basic
            'invoice_number' => ['required', 'string', 'max:50', 'unique:invoices,invoice_number'],
            'invoice_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:invoice_date'],

            // Seller
            'seller.name' => ['required', 'string', 'max:255'],
            'seller.address' => ['required', 'string'],
            'seller.gstin' => ['nullable', 'string', 'max:20'],
            'seller.pan' => ['nullable', 'string', 'max:20'],

            // Customer
            'customer.name' => ['required', 'string', 'max:255'],
            'customer.address' => ['required', 'string'],
            'customer.gstin' => ['nullable', 'string', 'max:20'],
            'customer.pan' => ['nullable', 'string', 'max:20'],

            // Supply
            'supply.place_of_supply' => ['nullable', 'string', 'max:100'],
            'supply.country_of_supply' => ['nullable', 'string', 'max:100'],

            // Amounts
            'amounts.subtotal' => ['required', 'numeric', 'min:0'],
            'amounts.discount' => ['nullable', 'numeric', 'min:0'],
            'amounts.taxable_amount' => ['required', 'numeric', 'min:0'],
            'amounts.cgst' => ['required', 'numeric', 'min:0'],
            'amounts.sgst' => ['required', 'numeric', 'min:0'],
            'amounts.total' => ['required', 'numeric', 'min:0'],
            'amounts.early_payment_discount' => ['nullable', 'numeric', 'min:0'],
            'amounts.final_amount' => ['nullable', 'numeric', 'min:0'],

            // Payment
            'payment_details.account_name' => ['nullable', 'string', 'max:255'],
            'payment_details.account_number' => ['nullable', 'string', 'max:50'],
            'payment_details.ifsc' => ['nullable', 'string', 'max:20'],
            'payment_details.bank_name' => ['nullable', 'string', 'max:255'],
            'payment_details.account_type' => ['nullable', 'string', 'max:255'],
            'payment_details.upi' => ['nullable', 'string', 'max:100'],

            'notes' => ['nullable', 'string'],

            // Items
            'items' => ['required', 'array', 'min:1'],

            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.hsn' => ['nullable', 'string', 'max:20'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.gst_percent' => ['required', 'numeric', 'min:0'],

            'items.*.taxable_amount' => ['required', 'numeric', 'min:0'],
            'items.*.cgst' => ['required', 'numeric', 'min:0'],
            'items.*.sgst' => ['required', 'numeric', 'min:0'],
            'items.*.total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors()->all(),
                'status'  => 'error',
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function passedValidation(): void
    {
        $this->data = InvoiceDTO::fromArray(
            $this->validated()
        );
    }
}