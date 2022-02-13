<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverRequest extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='driver_requests';

    protected $fillable=[
        'name',
        'email',
        'phone_number',
        'driver_license',
        'status',
    ];
}


