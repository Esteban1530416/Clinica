<template>
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">Lista de citas</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">

                <button class="btn btn-success mb-3" @click="newModal">
                   Registrar nueva cita
                </button>

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
                                        <th>Detalles</th>
                                        <th>Doctor</th>
                                        <th>Paciente</th>
                                        <th>Padecimiento </th>
                                        <th>Observaciones</th>

                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="cita in citas" :key="cita.id">
                                        <td>{{cita.id }}</td>
                                        <td>
                                          <span v-show="cita.state==1" class="badge badge-pill badge-info ">
                                             Agendada
                                          </span>

                                          <span v-show="cita.state==2" class="badge badge-pill badge-success ">
                                             Atentendida
                                          </span>
                                        </td>
                                        <td>{{cita.date}}</td>
                                        <td>{{cita.time }}</td>
                                        <td>{{cita.details }}</td>
                                        <td> <span v-for="doc in doctores" v-show="doc.id == cita.doctor_id"> {{ doc.name }}</span> </td>
                                        <td> <span v-for="paciente in pacientes" v-show="paciente.id == cita.patient_id"> {{ paciente.first_name +  " " + paciente.last_name }}</span> </td>
                                        <td> <span v-for="enf in enfermedades" v-show="enf.id == cita.id_disease"> {{ enf.name }}</span> </td>
                                        <td>{{cita.observations}}</td>


                                        <td>

                                          <button @click="editModal(cita)" class="btn btn-primary" > Padecimiento </button>
                                          <br>
                                          <button @click="abrirModalMedicamentos(cita.id)" class="btn btn-secondary">  Receta </button>
                                          <br>
                                          <button @click="eliminarCita(cita.id)" class="btn btn-danger">  Borrar </button>
                                          <br>

                                          <span v-show="cita.state==2">
                                            <a :href="'api/generarReporteCitas/'+cita.id" class="btn btn-success"> <i class="fas fa-file-pdf"></i>  </a> 
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
          <div class="modal fade" id="modalMedicinas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Medicina que se receta en la cita</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                <form @submit.prevent="guardarMedicamento()" >

                    <div class="form-group">
                        <label>Medicamento:</label>
                        <select class="form-control" id="medicamento" name="medicamento" required>
                            <option v-for="med in medicamentos" :value="med.id">{{med.name}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input type="text" id="observaciones" name="observaciones" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>

                </form>

                <hr>

                  <table class="table table-sm table-hover table-bordered">



                      <thead class="thead-dark">
                        <tr>
                            <th>Medicina</th>
                            <th>Cantidad</th>
                            <th>Presentacion</th>
                            <th>Accion</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="medicina in medicamentosCita" :key="medicina.id">
                            <td>{{medicina.name}}</td>
                            <td>{{medicina.observations }}</td>
                            <td>{{medicina.presentation}}</td>
                            <td>
                              <button @click="eliminarMedicamento(medicina.id)" class="btn btn-danger"> Borrar </button>
                            </td>
                        </tr>
                      </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

          <!-- Modal padecimietos-->
          <div class="modal fade" id="modalPadecimientos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Observaciones de la cita</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <form @submit.prevent="actualizarCita()" >

                      <div class="form-group">
                          <label>Enfermedad:</label>
                          <select class="form-control" name="disease" v-model="form.id_disease" :class="{ 'is-invalid': form.errors.has('id_disease') }" required>
                              <option v-for="enf in enfermedades" :value="enf.id">{{enf.name}}</option>
                          </select>
                          <has-error :form="form" field="id_disease"></has-error>
                      </div>

                      <div class="form-group">
                          <label>Observaciones:</label>
                          <textarea v-model="form.observations" id="observations" name="observations" rows="8" cols="80"
                          :class="{ 'is-invalid': form.errors.has('observations') }" class="form-control"></textarea>
                          <has-error :form="form" field="date"></has-error>
                      </div>

                      <button type="submit"  class="btn btn-primary">Guardar</button>
                  </form>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
              pacientes: [],
              doctores: [],
              enfermedades : [],
              medicamentos: [],
              medicamentosCita: []
            }

        }, methods:{

          eliminarMedicamento(id){

              swal.fire({
                  title: '¿Estas seguro que deseas eliminar el medicamento de la cita?',
                  text: "",
                  showCancelButton: true,
                  confirmButtonColor: '#3085d0',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
              }).then((result) => {
                  if (result.value) {
                  this.form.delete('api/borrarCitaMedicina/'+id)
                      .then(() => {

                              swal.fire(
                                  'Eliminado!',
                                  'Medicina eliminada',
                                  'success'
                              )

                              axios.get('api/obtenerCitaMedicina/'+this.cita.id)
                              .then(({data}) => {
                                  this.medicamentosCita = data;
                              })
                      })
                      .catch(() => {

                      })
                  }
              })

          },
          guardarMedicamento(){
            var medicina = document.getElementById("medicamento");
            var cantidad = document.getElementById("observaciones");

            axios.post('api/guardarCitaMedicina', {id_cita : this.cita.id ,medicina: medicina.value, cantidad: cantidad.value })
            .then((response)=>{

                //Una pequeña alerta en la esquina
                toast.fire({
                    type: 'success',
                    title: 'Medicina guardada correctamente'
                });

                medicina.value = "";
                cantidad.value = "";

                axios.get('api/obtenerCitaMedicina/'+this.cita.id)
                .then(({data}) => {
                    this.medicamentosCita = data;
                })

            }).catch(function (error) {
                // Maneja el error si la peticion no se llevo a cabo correctamente
                this.$Progress.fail();
                console.log(error);
            })

          },

            abrirModalMedicamentos(id){

              for(var i = 0; i < this.citas.length; i++){
                if(this.citas[i].id == id){
                  this.cita = this.citas[i];
                }
              }

              axios.get('api/obtenerCitaMedicina/'+id)
              .then(({data}) => {
                  this.medicamentosCita = data;
              })

              $('#modalMedicinas').modal('show');
            },

            actualizarCita(){

                this.form.state = 2;
                this.form.put('api/cita/'+this.form.id)
                .then(() => {
                    Fire.$emit('Afteredited');
                    toast.fire({
                        type: 'success',
                        title: 'Cita actualizada con exito'
                    });
                    this.form.reset();
                    $('#modalPadecimientos').modal('hide');
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },

            editModal(paciente){
                this.editMode = true;
                this.form.reset();
                $('#modalPadecimientos').modal('show');
                this.form.fill(paciente);
            },

            newModal(){
                window.location.href = "/citas";
            },

            eliminarCita(id){

              swal.fire({
                  title: '¿Estas seguro que deseas eliminar la cita con id '+ id + '?',
                  text: "",
                  showCancelButton: true,
                  confirmButtonColor: '#3085d0',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
              }).then((result) => {
                  if (result.value) {
                  this.form.delete('api/cita/'+id)
                      .then(() => {
                          swal.fire(
                            '¡Eliminado!',
                            'Cita eliminada con exito',
                            'success'
                          )
                          Fire.$emit('Afterdelete');
                          this.form.reset();
                      })
                      .catch(() => {
                      })
                  }
              })
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
