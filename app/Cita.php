<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model {
  
    protected $table = 'appointments';
    public $timestamps = false;

    protected $fillable = [
      'id', 'date', 'time', 'details', 'id_disease', 'doctor_id', 'patient_id',	'payment',	'observations',	'state'
    ];

}
