<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PacienteAlergias;
use Illuminate\Support\Facades\DB;

class PacienteAlergiasController extends Controller
{
    //
    public function index($id){
        //Traer todos los datos del modelo PacienteAlergias (SELECT * FROM patient_allergies)
        //return DB::table('patient_allergies')->where('id_patient', '=', $id)->get();

        return DB::table('patient_allergies')
            ->join('allergies', 'allergies.id', '=', 'patient_allergies.id_allergy')
            ->select('allergies.*', 'patient_allergies.id as pid')
            ->where('patient_allergies.id_patient', '=', $id)
            ->get();
    }

    public function store(Request $request){
        //
        /*$pacienteAlergias = PacienteAlergias::create($request->all());
        return ['mensaje' => 'relacion agregada'];*/

        DB::table('patient_allergies')->insert(
            ['id_patient' => $request->id_paciente, 'id_allergy' => $request->id_alergia]
        );

        return ['mensaje' => 'guardado'];
    }

    public function update(Request $request, $id) {
        //
        $pacienteAlergias = PacienteAlergias::findOrFail($id);
        $pacienteAlergias->update($request->all());
        return ['mensaje' => 'actualizado'];
    }

    public function destroy($id) {
        //
        $pacienteAlergias = PacienteAlergias::findOrFail($id);
        $pacienteAlergias->delete();
        return ['mensaje' => 'relacion eliminada'];
    }
}
