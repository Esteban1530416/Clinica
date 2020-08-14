<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Importamos el modelo para trabajar con su respectiva tabla
use App\Enfermedades;

class EnfermedadesController extends Controller
{
  public function index(){
      //Traer todos los datos del modelo Enfermedades (SELECT * FROM diseases)
      return Enfermedades::all();
  }

  public function store(Request $request){
      //
      $enfermedades = Enfermedades::create($request->all());
      return ['mensaje' => 'enfermedad agregada'];
  }

  public function update(Request $request, $id) {
      //
      $enfermedades = Enfermedades::findOrFail($id);
      $enfermedades->update($request->all());
      return ['mensaje' => 'actualizado'];
  }

  public function destroy($id) {
      //
      $enfermedades = Enfermedades::findOrFail($id);
      $enfermedades->delete();
      return ['mensaje' => 'enfermedad eliminado'];
  }
}
