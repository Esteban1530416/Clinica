<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paciente; //Se importa el modelo del paciente para trabajar con su respectiva tabla
use DB;

class PacienteController extends Controller
{
    public function index(){
        //Traer todos los datos del modelo Paciente (SELECT * FROM patient)
        return Paciente::all();
        //return Paciente::where('type', '=', $type )->get();

        //$users = DB::table('users')->select('name', 'email as user_email')->get();


    }

    public function store(Request $request){
        //
        $paciente = Paciente::create($request->all());
        return ['mensaje' => 'paciente creado'];
    }

    public function update(Request $request, $id) {
        //
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());
        return ['mensaje' => 'actualizado'];
    }

    public function destroy($id) {
        //
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
        return ['mensaje' => 'paciente eliminado'];
    }

    public function compartirPaciente($id){

      return DB::table('patient_users')
          ->join('users as me', 'me.id', '=', 'patient_users.id_user')
          ->join('users as ma', 'ma.id', '=', 'patient_users.medico_asociado')
          ->select('patient_users.*', 'me.name as nombreMedico',
                  'ma.name as nombreAsociado')
          ->where('patient_users.id_patient', '=', $id)
          ->get();
    }

    public function guardarCompartir(Request $request){
      DB::table('patient_users')->insert(
          ['id_user' => $request->id_medico,
           'id_patient' => $request->id_paciente,
           'medico_asociado' => $request->id_asociado,
           'fecha' => date('Y-m-d')]
      );

      return ['mensaje' => 'comparticion guardada correctamente'];
    }

    public function eliminarCompartir($id){
      DB::table('patient_users')->where('patient_users.id', '=', $id)->delete();
      return ['mensaje' => 'eliminado'];
    }

    public function obtenerPacientes($id){
        return DB::table('patient_users')
          ->join('patient', 'patient.id', '=', 'patient_users.id_patient')
          ->select('patient.*')
          ->where('patient_users.medico_asociado', '=', $id)
          ->get();
    }

}
