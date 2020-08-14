<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PacienteAlergias extends Model
{
    //
    protected $table = 'patient_allergies';
    public $timestamps = false;

    protected $fillable = [
      'id',	'id_patient',	'id_allergy'
    ];
}
