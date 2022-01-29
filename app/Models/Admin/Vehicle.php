<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='vehicles';

    protected $fillable=[
        'service_id',
        'name',
        'max_passenger',
        'picture',
        'is_private',
        'is_shared',
    ];

    public function Service()
    {

        return $this->belongsTo('App\Models\Admin\Service','service_id','id');
        

    } 
}
