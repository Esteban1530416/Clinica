<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Importamos el modelo para trabajar con su respectiva tabla
use App\Medicina;
use DB;

class MedicinaController extends Controller
{
  public function index(){
      //Traer todos los datos del modelo Medicina (SELECT * FROM medicine)
      return Medicina::all();
  }

  public function store(Request $request){
      //
      $medicina = Medicina::create($request->all());
      return ['mensaje' => 'medicina agregada'];
  }

  public function update(Request $request, $id) {
      //
      $medicina = Medicina::findOrFail($id);
      $medicina->update($request->all());
      return ['mensaje' => 'actualizado'];
  }

  public function destroy($id) {
      //
      $medicina = Medicina::findOrFail($id);
      $medicina->delete();
      return ['mensaje' => 'medicina eliminado'];
  }

  public function guardarCitaMedicina(Request $request)
  {
     DB::table('appointment_medicine')->insert(
              ['id_appointment' => $request->id_cita, 'id_medicine' => $request->medicina, 'observations' => $request-> cantidad ]
          );

          return 'guardado';
  }

  public function obtenerCitaMedicina($id)
  {
    return DB::table('appointment_medicine')
            ->join('medicine', 'medicine.id', '=', 'appointment_medicine.id_medicine')
            ->select('appointment_medicine.*', 'medicine.*')
            ->where('appointment_medicine.id_appointment', '=', $id)
            ->get();
  }

  public function borrarCitaMedicina($id)
  {
    DB::table('appointment_medicine')->where('id_medicine', '=', $id)->delete();
    return 'eliminado';
  }
}
