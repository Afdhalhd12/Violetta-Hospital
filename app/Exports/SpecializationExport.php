<?php

namespace App\Exports;

use App\Models\Specialization;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class SpecializationExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Specialization::all();
    }
    private $no = 0;

    public function map($specialization): array
    {
        return [
            ++$this->no,
            $specialization->specialist,
            $specialization->description,
            Carbon::parse($specialization->created_at)->format('d-m-Y H:i:s'),
        ];
    }
    public function headings(): array
    {
        return [
            'No',
            'Specialist',
            'Description',
            'Created At',
        ];
    }
}
