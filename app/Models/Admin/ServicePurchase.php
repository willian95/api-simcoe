<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePurchase extends Model
{
    use HasFactory;

    public $table='service_purchase';

    protected $fillable=[
        'service_type_id',
        'to_airport_group_id',
        'to_return_group_id',
        'airport_id',
        'payment_type_id',
        'init_date_park',
        'end_date_park',
        'to_airport_passengers',
        'to_airport_bags',
        'to_airport_pets',
        'to_airport_flight_number',
        'to_airport_is_private',
        'to_airport_is_shared',
        'departure_time',
        'departure_date',
        'to_airport_stops',
        'to_return_passengers',
        'to_return_bags',
        'to_return_pets',
        'to_return_flight_number',
        'to_return_is_private',
        'to_return_is_shared',
        'to_return_time',
        'to_return_date',
        'to_return_stops',
        'pickup_base_borden',
        'return_base_borden',
        'name',
        'email',
        'phone_number',
        'destination',
        'pickup_postal_code',
        'pickup_street',
        'pickup_unit',
        'dropoff_postal_code',
        'dropoff_street',
        'dropoff_unit',
        'purchase_status',
        'total',
    ];

}	