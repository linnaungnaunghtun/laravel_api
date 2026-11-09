<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class VoucherItemsExport implements FromCollection, WithHeadings
{
    protected $orderItems;

    public function __construct($orderItems)
    {
        $this->orderItems = $orderItems;
    }

    public function collection()
    {
        return $this->orderItems->map(function ($item) {
            return [
                'Voucher ID' => $item->voucher_id_code,
                'Date' => $item->created_at->format('Y-m-d'),
                'Customer Name' => $item->customer_name ?? '',
                'Customer Phone' => $item->customer_phone ?? '',
                'Sale Type' => $item->sale_type,
                'Brand' => $item->brand_name ?? '',
                'Category' => $item->category_name ?? '',
                'Product Name' => $item->product_name,
                'Product Code' => $item->product_code,
                'Barcode' => $item->barcode,
                'Fitting' => $item->fit_name ?? '',
                'Size' => $item->size_name,
                'Original Price' => $item->original_price,
                'Discount' => $item->discount ?? 0,
                'Sale Price' => $item->sale_price,
                'Display Price' => $item->display_price,
                'Profit' => $item->profit,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Voucher ID',
            'Date',
            'Customer Name',
            'Customer Phone',
            'Sale Type',
            'Brand',
            'Category',
            'Product Name',
            'Product Code',
            'Barcode',
            'Fitting',
            'Size',
            'Original Price',
            'Discount',
            'Sale Price',
            'Display Price',
            'Profit',
        ];
    }
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
