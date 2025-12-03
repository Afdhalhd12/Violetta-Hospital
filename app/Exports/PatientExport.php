<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

      $patientId = Auth::id();

     return Appointment::with('doctor')->where('user_id', $patientId)->orderBy('date', 'asc')->get();
    }
    private $no = 0;
    public function map($appointment): array
    {
        return [

            ++$this->no,
            $appointment->doctor->name,
            Carbon::parse($appointment->date)->format('d-m-Y'),
            $appointment->time,
            ucfirst($appointment->status),
            Carbon::parse($appointment->created_at)->format('d-m-Y H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Doctor Name',
            'Date',
            'Time',
            'Status',
            'Created At',
        ];
    }
}



