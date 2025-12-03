<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
     protected $fillable = [
        'user_id',
        'doctor_id',
        'date',
        'time',
        'status',
        'notes',
        'response',
     ];

      public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    protected $casts = [
    'date' => 'date',
    'time' => 'datetime:H:i',
];

}
