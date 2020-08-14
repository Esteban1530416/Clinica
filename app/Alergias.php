<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alergias extends Model
{
    //
    protected $table = 'allergies';
    public $timestamps = false;

    protected $fillable = [
      'id',	'name',	'details',	'type'
    ];
}
