<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Importamos el modelo para trabajar con su respectiva tabla
use App\Alergias;

class AlergiasController extends Controller
{
  public function index(){
      //Traer todos los datos del modelo Alergias (SELECT * FROM allergies)
      return Alergias::all();
  }

  public function store(Request $request){
      //
      $alergias = Alergias::create($request->all());
      return ['mensaje' => 'alergia agregada'];
  }

  public function update(Request $request, $id) {
      //
      $alergias = Alergias::findOrFail($id);
      $alergias->update($request->all());
      return ['mensaje' => 'actualizado'];
  }

  public function destroy($id) {
      //
      $alergias = Alergias::findOrFail($id);
      $alergias->delete();
      return ['mensaje' => 'alergia eliminado'];
  }
}
