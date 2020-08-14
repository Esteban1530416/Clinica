<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte-Cita-{{ $id }} </title>

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
      <h1>Cita #{{$id}}</h1>


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
      <b> ANALISIS CLINICO </b> <br>
      <b> Medico: </b> {{ $doctor[0]->name }} <br>
      <b> Observacion del medico: </b> {{ $cita[0]->observations }} <br>
      <b> Enfermedad: </b> {{ $enfermedad[0]->name }} <br>
      <b> Tipo de enfermedad: </b> {{ $enfermedad[0]->type }} <br>
      <b> Posible causa: </b> {{ $enfermedad[0]->causative }} <br>

      <hr class="my-4">
      <b> RECETA </b> <br>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Presentacion</th>
            <th scope="col">Detalles</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
          </tr>
        </thead>
        <tbody>
          @php
            foreach($medicamento as $med){
              echo '<tr>';
              echo '<td>' . $med->name . '</td>';
              echo '<td>' . $med->presentation . '</td>';
              echo '<td>' . $med->details . '</td>';
              echo '<td>' . $med->observations . '</td>';
              echo '<td> $ ' . $med->price . '</td>';
              echo '</tr>';
            }
          @endphp
        </tbody>
      </table>

    </div>




  </body>
</html>
