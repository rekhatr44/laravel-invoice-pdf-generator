<!DOCTYPE html>
<html>
<head>
<style>
/* ===== BASE ===== */
body {
    font-family: DejaVu Sans;
    font-size: 10px;
    margin: 10px;
}

table {
    width: 100%;
}

/* ===== HEADER ===== */
.header-table {
    border-collapse: collapse;
}

.title {
    font-size: 20px;
    font-weight: bold;
}

.header-small {
    width: auto;
    border-collapse: collapse;
    font-size: 9px;
    line-height: 1.6; 
}
.header-small .label {
    width: 90px;
    padding-right: 6px;
    white-space: nowrap;
}
.header-small td {
    padding: 1px 0;
}
.header-small .value {
    text-align: left;
}

/* ===== COMMON ===== */
.small { font-size: 9px; }
.right { text-align: right; }
.center { text-align: center; }
.bold { font-weight: bold; }

.mt-10 { margin-top: 10px; }
.mt-20 { margin-top: 20px; }

/* ===== BOX (BILLING) ===== */
.box {
    background: #f3f3f3;
    padding: 8px;
}

/* ===== ITEMS TABLE ===== */
.items-table {
    border-collapse: separate;
    border-spacing: 0 8px; /* row gap */
}

.items-table th {
    background: #333;
    color: white;
    padding: 8px;
    font-size: 9px;
    text-align: left;
}

.items-table td {
    padding: 8px 10px;
    border: none;
}
.text-right {
    text-align: right;
}

/* ===== BANK TABLE ===== */
.bank-table td {
    padding: 4px 0;
}

.bank-table .label {
    padding-right: 20px;
    white-space: nowrap;
}

.bank-table .value {
    text-align: left;
}

/* ===== TOTAL TABLE ===== */
.totals-table td {
    padding: 5px 0;
}

.totals-table td:last-child {
    text-align: right;
}
.totals-table .amount-words td {
    text-align: left;
}

/* ===== SUPPLY ===== */
.supply td {
    text-align: center;
}

/* ===== FOOTER ===== */
.footer {
    position: fixed;
    bottom: 10px;
    left: 20px;
    right: 20px;
    font-size: 9px;
}
</style>
</head>

<body>

<!-- HEADER -->
<table class="header-table">
<tr>
<td>
    <div class="title">Invoice</div>
  <table class="header-small">
    <tr>
        <td class="label">Invoice#</td>
        <td class="value">{{ $invoice->invoice_number }}</td>
    </tr>
    <tr>
        <td class="label">Invoice Date</td>
        <td class="value">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('F d, Y') }}</td>
    </tr>
    <tr>
        <td class="label">Due Date</td>
        <td class="value">{{ \Carbon\Carbon::parse($invoice->due_date)->format('F d, Y') }}</td>
    </tr>
</table>
</td>
<td class="right">
    <img src="{{ public_path('logo.png') }}" width="100">
</td>
</tr>
</table>

<!-- BILLING -->
<table class="info-table mt-10">
<tr>
<td width="50%">
    <div class="box">
        <strong>Billed by</strong><br><br>
        {{ $invoice->seller_name }}<br>
        {{ $invoice->seller_address }}<br><br>

        <table width="100%">
            <tr>
                <td><strong>GSTIN</strong></td>
                <td style="text-align:left;">{{ $invoice->seller_gstin }}</td>
            </tr>
            <tr>
                <td><strong>PAN</strong></td>
                <td style="text-align:left;">{{ $invoice->seller_pan }}</td>
            </tr>
        </table>
    </div>
</td>
<td width="50%">
    <div class="box">
        <strong>Billed to</strong><br><br>
        {{ $invoice->customer_name }}<br>
        {{ $invoice->customer_address }}<br><br>

        <table width="100%">
            <tr>
                <td><strong>GSTIN</strong></td>
                <td style="text-align:left;">{{ $invoice->customer_gstin }}</td>
            </tr>
            <tr>
                <td><strong>PAN</strong></td>
                <td style="text-align:left;">{{ $invoice->customer_pan }}</td>
            </tr>
        </table>
    </div>
</td>
</tr>
</table>

<table class="mt-10 small supply">
<tr>
<td>Place of Supply: <strong>{{ $invoice->place_of_supply }}</strong></td>
<td>Country of Supply: <strong>{{ $invoice->country_of_supply }}</strong></td>
</tr>
</table>

<!-- ITEMS -->
<table class="items-table mt-10">
<thead>
<tr>
<th>#</th>
<th>Description</th>
<th>HSN</th>
<th>Qty</th>
<th>GST</th>
<th class="text-right">Taxable</th>
<th class="text-right">SGST</th>
<th class="text-right">CGST</th>
<th class="text-right">Total</th>
</tr>
</thead>

<tbody>
@foreach($invoice->items as $i => $item)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $item->description }}</td>
<td>{{ $item->hsn }}</td>
<td>{{ $item->quantity }}</td>
<td>{{ $item->gst_percent }}%</td>
<td class="text-right">₹{{ number_format($item->taxable_amount,2) }}</td>
<td class="text-right">₹{{ number_format($item->sgst,2) }}</td>
<td class="text-right">₹{{ number_format($item->cgst,2) }}</td>
<td class="text-right">₹{{ number_format($item->total_amount,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<table class="mt-10" width="100%">
<tr>

<!-- BANK DETAILS -->
<td width="40%" valign="top">
    <strong>Bank & Payment Details</strong><br><br>
  <table class="bank-table">
<tr>
    <td class="label">Account Name</td>
    <td class="value">{{ $invoice->account_name }}</td>
</tr>
<tr>
    <td class="label">Account Number</td>
    <td class="value">{{ $invoice->account_number }}</td>
</tr>
<tr>
    <td class="label">IFSC</td>
    <td class="value">{{ $invoice->ifsc }}</td>
</tr>
<tr>
    <td class="label">Bank</td>
    <td class="value">{{ $invoice->bank_name }}</td>
</tr>
<tr>
    <td class="label">UPI</td>
    <td class="value">{{ $invoice->upi }}</td>
</tr>
</table>

<!-- TERMS -->
<div class="mt-20 small">
<strong>Terms and Conditions</strong>
<ol>
<li>Please pay within 15 days from the date of invoice. Overdue interest is 14% will be charged on delayed payments.</li>
<li>Please Quote invoice number within remaining funds.</li>
</ol>
</div>
</td>

<!-- QR CODE -->
<td width="20%" valign="top" style="text-align:center; padding-top: 30px;">
    UPI:Scan to Pay<br>
    <img src="{{ public_path('qrcode.png') }}" width="120" height="120">
</td>

<!-- TOTALS -->
<td width="40%" valign="top">
    <table class="totals-table">
<tr>
<td>Sub Total</td>
<td>₹{{ $invoice->subtotal }}</td>
</tr>
<tr>
<td>Discount</td>
<td>-₹{{ $invoice->discount }}</td>
</tr>
<tr>
<td>Taxable Amount</td>
<td>₹{{ $invoice->taxable_amount }}</td>
</tr>
<tr>
<td>CGST</td>
<td>₹{{ $invoice->cgst }}</td>
</tr>
<tr>
<td>SGST</td>
<td>₹{{ $invoice->sgst }}</td>
</tr>
<tr class="bold">
<td>Total</td>
<td style="font-size:14px;">₹{{ $invoice->total }}</td>
</tr>
<tr class="amount-words">
    <td colspan="2">
        <span class="small">Invoice total (in words):</span><br>
        <strong>{{ convertNumberToWords($invoice->final_amount) }}</strong>
    </td>
</tr>

<tr>
    <td>Early Payment Discount</td>
    <td class="right">₹{{ $invoice->early_payment_discount }}</td>
</tr>

<tr class="bold">
    <td>EarlyPay Amount</td>
    <td class="right">₹{{ $invoice->final_amount }}</td>
</tr>
</table>
</td>

</tr>
</table>



<!-- NOTES -->
<div class="mt-10 small">
<strong>Additional Notes</strong><br>
{{ $invoice->notes }}
</div>

<div class="footer small">
    For any queries email 
    <strong>sandeep6626@gmail.com</strong> 
    or call 
    <strong>+91 7016668462</strong>
</div>


</body>
</html>

@php
function convertNumberToWords($number)
{
    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($number)) . " Rupees Only";
}
@endphp