<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'estimated_minutes',
        'status',
    ];

    public function serviceDates()
    {
        return $this->hasMany(ServiceDate::class);
    }
}