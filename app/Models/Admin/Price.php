<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='prices';

    protected $fillable=[
        'airport_id',
        'service_id',
        'group_id',
        'shared_price',	
        'private_price',
        'unique_price',
        'base_borden_price',
        'extra_passenger_fee',
        'extra_family_price',	
        'parking_day_price',
        'price_per_stop', 
    ];

    public function Service()
    {

        return $this->belongsTo('App\Models\Admin\Service');
        

    } 

    public function Group()
    {

        return $this->belongsTo('App\Models\Admin\Group');
        

    } 

}


