<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago-Cita-{{ $id }} </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 2cm 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2.2cm;
            background-color: #001f3f;
            color: white;
            /*text-align: center;*/
            line-height: 30px;
        }


    </style>

  </head>
  <body>

    <header>
       <center> <h3> CONSULTORIO </h3> </center>
    </header>


    <div class="jumbotron jumbotron-fluid" style="background: white;">
      <h1>Pago de cita #{{$id}}</h1>


      <b> Fecha: </b> {{ $cita[0]->date}} ,
      <b> Hora: </b> {{ $cita[0]->time}} ,
      <b> Detalles: </b> {{ $cita[0]->details }}

      <hr class="my-4">
      <b> PACIENTE </b> <br>
      <b> Nombre: </b> {{ $paciente[0]->first_name }} ,
      <b> Apellido: </b> {{ $paciente[0]->last_name }} ,
      <b> Sexo: </b> {{ $paciente[0]->sex }} ,
      <b> Edad: </b> {{ $paciente[0]->age }} <br>
      <b> Altura: </b> {{ $paciente[0]->height }} ,
      <b> Peso: </b> {{ $paciente[0]->weight }}

      <hr class="my-4">
      <b> DETALLE DEL PAGO </b> <br>
      <b> Fecha: </b> {{ $cita[0]->fechaPago }} <br>
      <b> Total $: </b> {{ $cita[0]->total }} <br>
      <b> Detalles: </b> {{ $cita[0]->detallesPago }} <br>
      <b> Tipo: </b> {{ $cita[0]->type }}




    </div>




  </body>
</html>
