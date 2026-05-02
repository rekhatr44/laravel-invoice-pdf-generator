# Invoice PDF Generator

This is a simple Laravel-based Invoice PDF Generator that supports creating invoices, retrieving invoice details, and generating invoice PDFs.

## 🚀 Features

The project currently supports the following operations:

### 1. Create Invoice
- Create a new invoice with seller, customer, items, and tax details
- Uses DTO-based data transformation
- Transaction-safe database operations

### 2. Show Invoice
- Retrieve a single invoice by ID
- Includes related invoice items

### 3. Generate Invoice PDF
- Generates a downloadable/streamable PDF invoice
- Built using DomPDF

---

## 📦 Packages Used

- **Laravel Framework**
- **barryvdh/laravel-dompdf** – For PDF generation
- **MySQL** – Database
- **Laravel Eloquent ORM** – Database interactions

---

## ⚙️ Project Setup

### 1. Clone the repository
```bash
git clone https://github.com/rekhatr44/laravel-invoice-pdf-generator.git
cd invoice-api