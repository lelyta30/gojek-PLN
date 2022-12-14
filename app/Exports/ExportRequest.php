<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportRequest implements FromArray, WithHeadings, WithHeadingRow
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        return [
            'No',
            'Id',
            'Tanggal Request',
            'Jenis Permohonan',
            'Nama Penyervis',
            'Deskripsi',
            'Status',
            'Rating',
        ];
    }
}
