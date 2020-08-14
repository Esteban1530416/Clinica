<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use DB;

class PagosController extends Controller
{
    public function index($id){
        return DB::table('appointments')
            ->join('payments', 'payments.id', '=', 'appointments.payment')
            ->select('payments.*')
            ->where('appointments.id', '=', $id)
            ->get();
    }

    public function store(Request $request){
        $pago = Pago::create([
            "date"=> date("Y-m-d"),
            "total" => $request->total,
            "details" => $request->detalles,
            "type" => $request->tipo,
            "state" => 1]);

        $pagoCita = DB::table('appointments')
              ->where('appointments.id', $request->id_cita)
              ->update(['payment' => $pago->id]);

        return "Pago guardado con exito";
    }

    public function update(Request $request, $id){
        //
    }

    public function destroy($id){
        $pago = Pago::findOrFail($id);
        $pago->delete();
        return ['mensaje' => 'pago eliminado'];
    }
}
