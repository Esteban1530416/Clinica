<template>
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">Pagos</h1>
                        <h5> Lista de citas y sus pagos </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Doctor</th>
                                        <th>Paciente</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="cita in citas" :key="cita.id">
                                        <td>{{cita.id }}</td>
                                        <td>
                                          <span v-show="cita.payment==null" class="badge badge-pill badge-warning ">
                                             No pagada
                                          </span>
                                          <span v-show="cita.payment!=null" class="badge badge-pill badge-success ">
                                             Pagada
                                          </span>
                                        </td>
                                        <td>{{cita.date}}</td>
                                        <td>{{cita.time }}</td>
                                        <td> <span v-for="doc in doctores" v-show="doc.id == cita.doctor_id"> {{ doc.name }}</span> </td>
                                        <td> <span v-for="paciente in pacientes" v-show="paciente.id == cita.patient_id"> {{ paciente.first_name +  " " + paciente.last_name }}</span> </td>
                                        <td>
                                          <button @click="registrarPago(cita)" class="btn btn-primary" > Pagar </button>
                                          <br>

                                          <span v-show="cita.payment!=null">
                                            <a :href="'api/generarReportePago/'+cita.id" class="btn btn-secondary">
                                              <i class="fas fa-file-pdf"></i>
                                            </a>
                                          </span>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          <!-- Modal medicinas-->
          <div class="modal fade" id="modalPagos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Detalle del pago de cita</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form @submit.prevent="guardarPago()" >

                    <div class="form-group">
                        <label>Tipo de pago:</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="efectivo"> Efectivo </option>
                            <option value="tarjeta"> Tarjeta </option>
                            <option value="transferencia"> Transferencia electronica </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Total:</label>
                        <input type="number" id="total" name="total" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Detalles:</label>
                        <input type="text" id="detalles" name="detalles" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>

                <hr>
                  <table class="table table-sm table-hover table-bordered">
                      <thead class="thead-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Detalles</th>
                            <th>Tipo</th>
                            <th>Accion</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="p in pagosCita" :key="p.id">
                            <td>{{p.date}}</td>
                            <td>{{p.total}}</td>
                            <td>{{p.details}}</td>
                            <td>{{p.type}}</td>
                            <td>
                              <button @click="eliminarPago(p.id)" class="btn btn-danger">
                                Borrar
                              </button>
                            </td>
                        </tr>
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Patient",
        data(){
            return{
              editMode : false,
              form : new Form({
                  id : '',
                  date : '',
                  time : '',
                  details : '',
                  doctor_id : '',
                  patient_id: '',
                  observations: '',
                  id_disease: '',
                  state: 1,
              }),
              cita: {},
              citas: [],
              pagosCita: [],
              pacientes: [],
              doctores: [],
              enfermedades : [],
              medicamentos: [],
              medicamentosCita: []
            }

        }, methods:{
          guardarPago(){

            var tipo = document.getElementById("tipo");
            var total = document.getElementById("total");
            var detalles = document.getElementById("detalles");

            axios.post('api/pago',
              { id_cita: this.cita.id, tipo: tipo.value, total: total.value, detalles: detalles.value })
            .then((response)=>{
                toast.fire({
                    type: 'success',
                    title: 'Pago guardado correctamente'
                });
                tipo.value = "";
                total.value = "";
                detalles.value = "";

                axios.get('api/pago/'+this.cita.id)
                .then(({data}) => {
                    this.pagosCita = data;
                })

                axios.get('api/cita')
                .then(({data}) => {
                    this.citas = data;
                })

            }).catch(function (error) {
                // Maneja el error si la peticion no se llevo a cabo correctamente
                console.log(error);
            })

          },
          eliminarPago(id){

            swal.fire({
                title: '¿Estas seguro que deseas eliminar el pago de la cita?',
                text: "",
                showCancelButton: true,
                confirmButtonColor: '#3085d0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                this.form.delete('api/pago/'+id)
                    .then((data) => {

                      console.log(data);
                      toast.fire({
                          type: 'success',
                          title: 'Pago borrado'
                      });

                      axios.get('api/pago/'+this.cita.id)
                      .then(({data}) => {
                          this.pagosCita = data;
                      })

                      axios.get('api/cita')
                      .then(({data}) => {
                          this.citas = data;
                      })

                    })
                    .catch(() => {

                    })
                }
            })

          },
          registrarPago(cita){
            this.cita = cita;

            axios.get('api/pago/'+cita.id)
            .then(({data}) => {
                this.pagosCita = data;
                console.log(data);
            })
            //pagosCita
            $('#modalPagos').modal('show');
          },

            cargarCitas(){
                this.eventos = [];
                axios.get('api/pacientes')
                .then(({data}) => {
                    this.pacientes = data
                })

                axios.get('api/doctores')
                .then(({data}) => {
                  this.doctores = data;
                })

                axios.get('api/cita')
                .then(({data}) => {
                    this.citas = data;
                })

                axios.get('api/enfermedades')
                .then(({data}) => {
                    this.enfermedades = data;
                })

                axios.get('api/medicinas')
                .then(({data}) => {
                    this.medicamentos = data;
                })



            }
        },

        created(){
            this.cargarCitas();
            Fire.$on('AfterCreated',() => this.cargarCitas());
            Fire.$on('Afterdelete',() => this.cargarCitas());
            Fire.$on('Afteredited',() => this.cargarCitas());
        }

    }
</script>

<style scoped>

</style>
