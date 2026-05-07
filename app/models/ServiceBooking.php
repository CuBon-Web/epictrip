<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $table = 'service_bookings';

    protected $fillable = [
        'service_id',
        'name',
        'email',
        'phone',
        'note',
        'total',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
