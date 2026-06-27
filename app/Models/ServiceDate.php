<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type_id',
        'available_date',
        'start_time',
        'end_time',
        'capacity',
        'status',
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}