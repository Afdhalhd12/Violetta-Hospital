<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class UserExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::whereIn('role', ['doctor'])->get();
    }

    private $no = 0;
    public function map($user): array
    {
        return [
            ++$this->no,
            $user->name,
            $user->email,
            ucwords($user->role),
            $user->specialization ? $user->specialization->specialist : 'N/A',
            Carbon::parse($user->created_at)->format('d-m-Y H:i:s'),
        ];
    }
    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Email',
            'Role',
            'Specialization',
            'Created At',
        ];
    }
}
