<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\DTOs\Invoice\InvoiceDTO;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Services\Invoice\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService $service
    ) {}

    public function show(Invoice $invoice)
    {
        try {
            return response()->json([
                'message' => 'Invoice fetched successfully',
                'data' => $invoice->load('items')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(InvoiceRequest $request)
    {
        try {

            DB::beginTransaction();

            $dto = InvoiceDTO::fromArray($request->all());

            $invoice = $this->service->create($dto);

            DB::commit();

            return response()->json([
                'message' => 'Invoice created successfully',
                'data' => $invoice->load('items')
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function invoicePdfDownload(Invoice $invoice)
    {
        try {
            $invoice->load('items');

            $pdf = Pdf::loadView('invoices.invoice-pdf', [
                'invoice' => $invoice
            ]);

             return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
        // return $pdf->stream('invoice_' . $invoice->invoice_number . '.pdf');
            } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to generate PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
