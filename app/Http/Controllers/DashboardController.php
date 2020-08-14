<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller {

    public function totalAlergias(){
        $alergias = DB::table('allergies')->select('allergies.*')->get();
        return count($alergias);
    }

    public function totalCitas(){
        $citas = DB::table('appointments')->select('appointments.*')->get();
        return count($citas);
    }

    public function totalEnfermedades(){
        $enfermedades = DB::table('diseases')->select('diseases.*')->get();
        return count($enfermedades);
    }

    public function totalMedicinas(){
        $medicinas = DB::table('medicine')->select('medicine.*')->get();
        return count($medicinas);
    }

    public function totalPacientes(){
        $pacientes = DB::table('patient')->select('patient.*')->get();
        return count($pacientes);
    }

    public function totalPagos(){
        $pagos = DB::table('payments')->select('payments.*')->get();
        return count($pagos);
    }

    public function totalUsuarios(){
        $usuarios = DB::table('users')->select('users.*')->get();
        return count($usuarios);
    }

    public function totalCompartidos($id){
      $compartidos = DB::table('patient_users')->select('patient_users.*')->where('patient_users.medico_asociado', '=', $id)->get();
      return count($compartidos);
    }

}
