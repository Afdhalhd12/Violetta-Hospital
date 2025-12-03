<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

      $doctorId = Auth::id();

     return Appointment::with('patient')->where('doctor_id', $doctorId)->orderBy('date', 'asc')->get();
    }
    private $no = 0;
    public function map($appointment): array
    {
        return [

            ++$this->no,
            $appointment->patient->name,
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
            'Patient Name',
            'Date',
            'Time',
            'Status',
            'Created At',
        ];
    }
}



