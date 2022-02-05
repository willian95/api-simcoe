<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Town extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table='towns';

    protected $fillable=[
        'group_id',
        'name',
    ];

    public function Group()
    {

        return $this->belongsTo('App\Models\Admin\Group','group_id','id');
        

    } 
}
