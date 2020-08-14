<?php
//hola
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
//Route::apiResources(['patient' => 'API\PacienteController']);

//Rutas para administrar a los pacientes
Route::get('/pacientes', 'PacienteController@index');

Route::get('/obtenerPacientes/{id}', 'PacienteController@obtenerPacientes');
Route::put('/paciente/{id}', 'PacienteController@update');
Route::post('/paciente', 'PacienteController@store');
Route::delete('/paciente/{id}', 'PacienteController@destroy');

//Rutas para administrar las enfermedades
Route::get('/enfermedades', 'EnfermedadesController@index');
Route::post('/enfermedades', 'EnfermedadesController@store');
Route::put('/enfermedades/{id}', 'EnfermedadesController@update');
Route::delete('/enfermedades/{id}', 'EnfermedadesController@destroy');

//Rutas para administrar las medicinas
Route::get('/medicinas', 'MedicinaController@index');
Route::post('/medicinas', 'MedicinaController@store');
Route::put('/medicinas/{id}', 'MedicinaController@update');
Route::delete('/medicinas/{id}', 'MedicinaController@destroy');

Route::post('/guardarCitaMedicina', 'MedicinaController@guardarCitaMedicina');
Route::get('/obtenerCitaMedicina/{id}', 'MedicinaController@obtenerCitaMedicina');
Route::delete('/borrarCitaMedicina/{id}', 'MedicinaController@borrarCitaMedicina');

//Rutas para administrar las alergias
Route::get('/alergias', 'AlergiasController@index');
Route::post('/alergias', 'AlergiasController@store');
Route::put('/alergias/{id}', 'AlergiasController@update');
Route::delete('/alergias/{id}', 'AlergiasController@destroy');

//Rutas para administrar las alergias de los pacientes
Route::get('/alergiasPaciente/{id}', 'PacienteAlergiasController@index');
Route::post('/alergiasPaciente', 'PacienteAlergiasController@store');
Route::put('/alergiasPaciente/{id}', 'PacienteAlergiasController@update');
Route::delete('/alergiasPaciente/{id}', 'PacienteAlergiasController@destroy');

//Rutas para administrar las citas
Route::get('/doctores', 'API\UserController@obtenerDoctores');
Route::get('/cita', 'CitasController@index');
Route::put('/cita/{id}', 'CitasController@update');
Route::post('/cita', 'CitasController@store');
Route::delete('/cita/{id}', 'CitasController@destroy');

//Rutas para administrar compartir expedientes del paciente
Route::get('/compartirPaciente/{id}', 'PacienteController@compartirPaciente');
Route::post('/compartirPaciente', 'PacienteController@guardarCompartir' );
Route::delete('/compartirPaciente/{id}','PacienteController@eliminarCompartir' );
Route::get('/medicosAsociados', 'API\UserController@obtenerAsociados');

//Rutas para administrar los pagos de las citas
Route::get('/pago/{id}', 'PagosController@index');
Route::post('/pago', 'PagosController@store');
Route::delete('/pago/{id}', 'PagosController@destroy');

//Rutas para administrar los reportes del sistema
Route::get('/generarReporteCitas/{id}', 'ReportesController@generarReporteCitas');
Route::get('/generarReporteExpediente/{id}', 'ReportesController@generarReporteExpediente');
Route::get('/generarReportePago/{id}', 'ReportesController@generarReportePago');

//Rutas para administrar el dashboard
Route::get('/totalusuarios', 'DashboardController@totalUsuarios');
Route::get('/totalcitas', 'DashboardController@totalCitas');
Route::get('/totalenfermedades', 'DashboardController@totalEnfermedades');
Route::get('/totalpacientes', 'DashboardController@totalPacientes');
Route::get('/totalalergias', 'DashboardController@totalAlergias');
Route::get('/totalmedicinas', 'DashboardController@totalMedicinas');
Route::get('/totalpagos', 'DashboardController@totalPagos');
Route::get('/totalcomaprtidos/{id}', 'DashboardController@totalCompartidos');
