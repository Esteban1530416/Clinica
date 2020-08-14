<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    //
    protected $table = 'patient';
    public $timestamps = false;

    protected $fillable = [
      'id', 'first_name', 'last_name', 'age', 'height', 'weight', 'sex',	'birth',	'photo',	'address',	'city',	'state',	'phone'

    ];
}
