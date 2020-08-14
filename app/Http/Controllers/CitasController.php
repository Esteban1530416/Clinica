<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cita;

class CitasController extends Controller {
    public function index(){
        return Cita::all();
    }

    public function store(Request $request){
        $cita = Cita::create($request->all());
        return ['mensaje' => 'cita creada correctamente'];
    }

    public function update(Request $request, $id){
        $cita = Cita::findOrFail( $id );
        $cita->update( $request->all() );
        return ['mensaje' => 'cita actualizada'];
    }

    public function destroy($id){
        $cita = Cita::findOrFail($id);
        $cita->delete();
        return ['mensaje' => 'cita eliminada'];
    }
}
