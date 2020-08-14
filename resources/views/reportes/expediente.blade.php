<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente-{{ $id }} </title>

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
            text-align: center;
            line-height: 30px;
        }


    </style>

  </head>
  <body>

    <header>
       <center> <h3> CONSULTORIO </h3> </center>
    </header>


    <div class="jumbotron jumbotron-fluid" style="background: white;">
      <h1>EXPEDIENTE #{{$id}}</h1>

      <b> PACIENTE </b> <br>
      <b> Nombre: </b> {{ $paciente[0]->first_name }} ,
      <b> Apellido: </b> {{ $paciente[0]->last_name }} ,
      <b> Sexo: </b> {{ $paciente[0]->sex }} ,
      <b> Edad: </b> {{ $paciente[0]->age }} <br>
      <b> Altura: </b> {{ $paciente[0]->height }} ,
      <b> Peso: </b> {{ $paciente[0]->weight }},
      <b> IMC: </b> {{ ($paciente[0]->weight) / ( $paciente[0]->height * $paciente[0]->height) }}


      <hr class="my-4">
      <b> CITAS </b> <br>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Detalles</th>
            <th scope="col">Doctor</th>
            <th scope="col">Observaciones</th>
            <th scope="col">Padecimiento</th>
          </tr>
        </thead>
        <tbody>
          @php
            foreach($citas as $cita){
              echo '<tr>';
                echo '<td>' . $cita->id . '</td>';
              echo '<td>' . $cita->date . '</td>';
              echo '<td>' . $cita->time . '</td>';
              echo '<td>' . $cita->details . '</td>';
              echo '<td>' . $cita->doctor . '</td>';
              echo '<td>' . $cita->observations . '</td>';
              echo '<td>' . $cita->enfermedad . '</td>';
              echo '</tr>';
            }
          @endphp
        </tbody>
      </table>


      <hr class="my-4">
      <b> MEDICAMENTOS </b> <br>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">cita</th>
            <th scope="col">Medicamento</th>
            <th scope="col">Presentacion</th>
            <th scope="col">Detalles</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
          </tr>
        </thead>
        <tbody>
          @php
          foreach($medicamentos as $med){
            echo '<tr>';
            echo '<td>' . $med->idCita . '</td>';
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
