<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //
    protected $table = 'payments';
    public $timestamps = false;

    protected $fillable = [
      'id', 'date', 'total', 'details', 'type', 'state'
    ];
}
