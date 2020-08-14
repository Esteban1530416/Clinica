<template>

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Agendar Citas</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card ">
                            <div class="card-header text-white bg-dark">Registrar cita</div>

                            <div class="card-body ">
                              * Da click sobre un dia para registrar una nueva cita
                              <!--	id	date	time	details	id_disease	doctor_id	patient_id	payment	observations	state -->

                              <form @submit.prevent="editMode ? actualizarCita() : crearCita()" >

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input v-model="form.date" type="date" id="date" name="date"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('date') }">
                                        <has-error :form="form" field="date"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label>Hora</label>
                                        <input v-model="form.time" type="time" name="time"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('time') }">
                                        <has-error :form="form" field="time"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label>Detalles</label>
                                        <textarea v-model="form.details" type="text" name="details"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('details') }">
                                        </textarea>
                                        <has-error :form="form" field="details"></has-error>
                                    </div>


                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select class="form-control" name="doctor_id" v-model="form.doctor_id" :class="{ 'is-invalid': form.errors.has('doctor_id') }" required>
                                            <option v-for="doctor in doctores" :value="doctor.id">{{doctor.name}}</option>
                                        </select>
                                        <has-error :form="form" field="doctor_id"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label>Paciente</label>
                                        <select class="form-control" name="patient_id" v-model="form.patient_id" :class="{ 'is-invalid': form.errors.has('patient_id') }" required>
                                            <option v-for="paciente in pacientes" :value="paciente.id">{{paciente.first_name + " " + paciente.last_name }}</option>
                                        </select>
                                        <has-error :form="form" field="patient_id"></has-error>
                                    </div>


                                    <button v-show="!editMode" type="submit" class="btn btn-success">Guardar</button>

                                    <button v-show="editMode" type="submit" class="btn btn-warning">Actualizar</button>
                                    <a v-show="editMode" @click="eliminarCita" class="btn btn-danger ml-2">Eliminar</a>

                              </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card ">
                            <div class="card-body ">
                                <Fullcalendar @eventClick="formularioActualizar" @dateClick="formularioAgregar" :weekends="false" :plugins="calendarPlugins" :events="eventos"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import Fullcalendar from "@fullcalendar/vue";
  import dayGridPlugin from "@fullcalendar/daygrid";
  import interactionPlugin from "@fullcalendar/interaction";
  import allLocales from '@fullcalendar/core/locales-all';

    export default {
        name: "Dashboard",
        components: {
          Fullcalendar
        },
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
                state: 1,
            }),
            
            cita: {},
            citas: [],
            pacientes: [],
            doctores: [],
            calendarPlugins: [dayGridPlugin, interactionPlugin],
            eventos: []
          }
        },
        methods:{

          formularioAgregar(arg) {
              this.editMode = false;
              this.form.reset();

              var fecha = document.getElementById("date");
              fecha.value = this.darFormatoFecha(arg.date);
              this.form.date = fecha.value;
              console.log(this.form);
          },

          actualizarCita(){

              this.$Progress.start();
              this.form.put('api/cita/'+this.form.id)
              .then(() => {
                  Fire.$emit('Afteredited');
                  toast.fire({
                      type: 'success',
                      title: 'Cita actualizada con exito'
                  });
                  this.form.reset();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },

          darFormatoFecha (date) {

            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
          },

          formularioActualizar(arg){

            this.editMode = true;

            this.form.reset();

            for (var i = 0; i < this.citas.length; i++) {
              if ( this.citas[i].id == arg.event.id ) {
                this.cita = this.citas[i];
              }
            }

            this.form.fill(this.cita);

          },

          eliminarCita(){

            swal.fire({
                title: '¿Estas seguro que deseas eliminar la cita con id '+ this.form.id + '?',
                text: "",
                showCancelButton: true,
                confirmButtonColor: '#3085d0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                this.form.delete('api/cita/'+this.form.id)
                    .then(() => {

                            swal.fire(
                                'Eliminado!',
                                'Cita elimnada con exito',
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

                  for (var i = 0; i < this.citas.length; i++) {
                    var evento = new Object();
                    evento.id = this.citas[i].id;
                    evento.title = this.citas[i].details;
                    evento.start = this.citas[i].date;
                    this.eventos.push(evento);
                  }

              })
          },

          crearCita(){



              this.form.post('api/cita')
              .then(() => {
                  Fire.$emit('AfterCreated');
                  toast.fire({
                      type: 'success',
                      title: 'Cita agendada con exito'
                  });
                  this.form.reset();
              }).catch(() => {
                  toast.fire({
                      type: 'success',
                      title: 'No se ha podido guardar la cita'
                  });
              });
          }

        },
        created(){
            this.cargarCitas();
            Fire.$on('AfterCreated',() => this.cargarCitas() );
            Fire.$on('Afterdelete',() => this.cargarCitas() );
            Fire.$on('Afteredited',() => this.cargarCitas() );
        }
    }
</script>

<style lang="css">
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";

.fc-title:hover {
  cursor: pointer;
}
</style>
