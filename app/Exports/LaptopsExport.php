<?php

namespace App\Exports;

use App\Models\Laptop;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaptopsExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Laptop::query();

        if(!empty($this->filters['departemen'])) {
            $query->where('departemen', $this->filters['departemen']);
        }

        if(!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if(!empty($this->filters['tanggal'])) {
            $query->whereDate('tanggal_pinjam', $this->filters['tanggal']);
        }

        return $query->get(['id','merk','tipe','status','departemen','tanggal_pinjam','tanggal_kembali']);
    }

    public function headings(): array
    {
        return ['ID','Merk','Tipe','Status','Departemen','Tanggal Pinjam','Tanggal Kembali'];
    }
}
