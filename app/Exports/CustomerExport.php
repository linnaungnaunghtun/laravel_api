<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::with(['level'])->get();
    }

    /**
     * Define the column headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Gender',
            'Age',
            'Age Range',
            'Address',
            'Remark',
            'City',
            'Township',
            'Level',
            'Created At',
        ];
    }

    /**
     * Map the data for each row
     *
     * @param Customer $customer
     * @return array
     */
    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->phone,
            $customer->gender,
            $customer->age,
            $customer->age_range,
            $customer->address,
            $customer->remark,
            $customer->city,
            $customer->township,
            $customer->level->level ?? 'N/A', // Access relationship
            $customer->created_at->format('Y-m-d'),
        ];
    }

    /**
     * Apply styles to the sheet
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Make the header row bold
            1 => ['font' => ['bold' => true]],
            'H' => ['alignment' => ['wrapText' => true]],
            'I' => ['alignment' => ['wrapText' => true]],
        ];
    }
}
