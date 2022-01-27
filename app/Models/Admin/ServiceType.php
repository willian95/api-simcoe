<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='service_types';

    protected $fillable=[
        'service_id',
        'name',
        'is_only_private',
        'discount_percentage',
    ];
}
