<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicina extends Model
{
    //
    protected $table = 'medicine';
    public $timestamps = false;

    protected $fillable = [
      'id',	'name',	'presentation',	'details',	'price'
    ];
}
