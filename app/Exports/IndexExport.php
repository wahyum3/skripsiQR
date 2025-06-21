<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Controllers\AdminDashboardController;

class IndexExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $headings;

    /**
     * @param Collection $data - Data yang ingin di-export
     * @param array $headings - Header kolom Excel
     */
    public function __construct(Collection $data, array $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}



