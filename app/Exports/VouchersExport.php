<?php

namespace App\Exports;

use App\Models\Voucher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VouchersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Voucher::with('customer', 'user')->get();
    }

    public function headings(): array
    {
        return [
            'Voucher ID',
            'Sale Date',
            'Customer Name',
            'Customer Phone',
            'Sale Type',
            'Payment Method',
            'Total Amount',
            'Discount %',
            'Discount Amount',
            'Cash Discount',
            'Tax %',
            'Tax Amount',
            'Net Total',
            'Net Profit',
        ];
    }

    public function map($voucher): array
    {
        return [
            $voucher->voucher_no,
            $voucher->voucher_date,
            $voucher->customer->name,
            $voucher->customer->phone ?? '',
            $voucher->sale_type,
            $voucher->payment_method,
            $voucher->total ?? 0,
            $voucher->discount_percentage ?? 0,
            $voucher->discount_percent_amount ?? 0,
            $voucher->cash_discount ?? 0,
            $voucher->tax ?? 0,
            $voucher->tax_amount ?? 0,
            $voucher->net_total ?? 0,
            $voucher->net_profit ?? 0,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }
}
