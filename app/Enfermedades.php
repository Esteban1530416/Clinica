<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enfermedades extends Model
{
    //
    protected $table = 'diseases';
    public $timestamps = false;

    protected $fillable = [
      'id',	'name',	'type',	'causative',	'mode_of_transmision'
    ];
}
