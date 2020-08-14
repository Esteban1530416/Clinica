<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;

class ReportesController extends Controller
{

    public function generarReporteCitas($id){

        $cita = DB::table('appointments')
            ->select('appointments.*')
            ->where('appointments.id', '=', $id)
            ->get();

        $doctor = DB::table('appointments')
            ->join('users', 'users.id', '=', 'appointments.doctor_id')
            ->select('users.*')
            ->where('appointments.id', '=', $id)
            ->get();

        $paciente = DB::table('appointments')
            ->join('patient', 'patient.id', '=', 'appointments.patient_id')
            ->select('patient.*')
            ->where('appointments.id', '=', $id)
            ->get();

        $enfermedad = DB::table('appointments')
            ->join('diseases', 'diseases.id', '=', 'appointments.id_disease')
            ->select('diseases.*')
            ->where('appointments.id', '=', $id)
            ->get();

        $medicamento = DB::table('appointments')
            ->join('appointment_medicine', 'appointment_medicine.id_appointment', '=', 'appointments.id')
            ->join('medicine', 'medicine.id', '=', 'appointment_medicine.id_medicine')
            ->select('medicine.*', 'appointment_medicine.*')
            ->where('appointments.id', '=', $id)
            ->get();

        //return view('pdf.cita', ['id' => $id, 'cita' => $cita, 'enfermedad' => $enfermedad, 'medicamento' => $medicamento, 'paciente' => $paciente, 'doctor' => $doctor ]);

        $pdf = PDF::loadView('reportes.cita', ['id' => $id, 'cita' => $cita, 'enfermedad' => $enfermedad, 'medicamento' => $medicamento, 'paciente' => $paciente, 'doctor' => $doctor ] );
        return $pdf->download('Cita#'. $id .'.pdf');

        /*$pdf = PDF::loadView('reportes.cita', ['id' => $id] );
        return $pdf->download('reporte_cita_'. $id .'.pdf');*/

    }

    public function generarReporteExpediente($id){

        $paciente = DB::table('patient')
          ->select('patient.*')
          ->where('patient.id', '=', $id)
          ->get();

        $citas = DB::table('appointments')
          ->join('users', 'users.id', '=', 'appointments.doctor_id')
          ->join('diseases', 'diseases.id', '=', 'appointments.id_disease')
          ->select('appointments.*', 'users.name as doctor', 'diseases.name as enfermedad')
          ->where('appointments.patient_id', '=', $id)
          ->get();

        $medicamentos = DB::table('appointments')
          ->join('appointment_medicine', 'appointment_medicine.id_appointment', '=', 'appointments.id')
          ->join('medicine', 'medicine.id', '=', 'appointment_medicine.id_medicine')
          ->select('medicine.*', 'appointment_medicine.*', 'appointments.id as idCita')
          ->where('appointments.patient_id', '=', $id)
          ->get();

        $pdf = PDF::loadView('reportes.expediente', [
          'id' => $id,
          'paciente' => $paciente,
          'citas' => $citas,
          'medicamentos' => $medicamentos ] );

        return $pdf->download('expediente_'. $id .'.pdf');
    }

    public function generarReportePago($id){


        $cita = DB::table('appointments')
          ->join('payments', 'payments.id', '=', 'appointments.payment')
            ->select('payments.*', 'payments.date as fechaPago', 'payments.details as detallesPago' ,'appointments.*')
            ->where('appointments.id', '=', $id)
            ->get();

        $paciente = DB::table('appointments')
            ->join('patient', 'patient.id', '=', 'appointments.patient_id')
            ->select('patient.*')
            ->where('appointments.id', '=', $id)
            ->get();


        $pdf = PDF::loadView('reportes.pago', ['id' => $id, 'paciente' => $paciente, 'cita' => $cita] );
        return $pdf->download('pago_'. $id .'.pdf');

        //return view('pdf.pago', ['id' => $id, 'pago' => $pago, 'cita' => $cita, 'doctor' => $doctor]);
    }


}
