<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='groups';

    protected $fillable=[
        'service_id',
        'name',
    ];

    public function Service()
    {

        return $this->belongsTo('App\Models\Admin\Service','id','service_id');
        

    } 


}
