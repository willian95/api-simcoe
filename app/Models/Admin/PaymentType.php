<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentType extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='payment_type';

    protected $fillable=[
        'icon',
        'description',
    ];
}


