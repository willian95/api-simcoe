<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceInfoRate extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='service_info_rates';

    protected $fillable=[
        'service_id',
        'max_pets',
        'max_bags',
        'max_passager',
        'max_carry_on_bag',
        'max_stops',
    ];
}


