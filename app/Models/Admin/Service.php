<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='services';

    protected $fillable=[
        'name',
        'is_shared_and_private',
        'has_groups',
        'icon',
        'depot_address',
        'description',
        'advice',
        'second_advice',
        'apply_sold_out',
        'is_sold_out',
        'purchase_advice',
    ];

    public function ServiceInfoRate()
    {

        return $this->belongsTo('App\Models\Admin\ServiceInfoRate','id','service_id');


    } 

    public function ServiceType()
    {

        return $this->belongsTo('App\Models\Admin\ServiceType','id','service_id');
        

    } 

}
