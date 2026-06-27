<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_type_id',
        'service_date_id',
        'payment_method_id',
        'mechanic_id',

        'amount',
        'payment_status',

        'vehicle_plate',
        'vehicle_brand',
        'vehicle_model',
        'vehicle_year',
        'current_mileage',

        'customer_notes',
        'admin_notes',

        'status',
        'mechanic_finished',
        'admin_confirmed',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'mechanic_finished' => 'boolean',
        'admin_confirmed' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mechanic()
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function serviceDate()
    {
        return $this->belongsTo(ServiceDate::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}