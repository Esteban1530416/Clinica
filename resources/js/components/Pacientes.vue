<template>
  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Pacientes</h1>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container">
        <button class="btn btn-success mb-3" @click="newModal">
          <i class="fas fa-user-injured"></i> Crear nuevo paciente </button>

          <div class="row justify-content-center">
            <div class="col-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Altura</th>
                        <th>Peso</th>
                        <th>Sexo</th>
                        <th>Fecha de nacimiento</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Telefono</th>
                        <th>Alergias</th>
                        <th>Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="paciente in pacientes" :key="paciente.id">
                        <td>{{paciente.id}}</td>
                        <td>{{paciente.first_name + " " + paciente.last_name}}</td>
                        <td>{{paciente.height }}</td>
                        <td>{{paciente.weight }}</td>
                        <td>{{paciente.sex}}</td>
                        <td>{{paciente.birth}}</td>
                        <td>{{paciente.address}}</td>
                        <td>{{paciente.city}}</td>
                        <td>{{paciente.phone}}</td>
                        <td>
                          <button @click="allergieModal(paciente)" class="btn btn-primary">Agregar</button>
                          </td>
                        <td>
                          <button @click="editModal(paciente)" class="btn btn-warning">Editar</button>
                          <button @click="deleteUser(paciente.id)" class="btn btn-danger">Eliminar</button>

                          <button @click="compartirPaciente(paciente)" class="btn btn-success">Compartir</button>


                          <span>
                            <a :href="'api/generarReporteExpediente/'+paciente.id" class="btn btn-secondary">
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

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 v-show="!editMode" class="modal-title" id="exampleModalLongTitle">Registrar paciente</h5>
                <h5 v-show="editMode" class="modal-title" id="exampleModalLongTitle">Actualizar paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="editMode ? updateUser() : createUser()" >
                <div class="modal-body">

                  <div class="form-group">
                    <label>Nombre</label>
                    <input v-model="form.first_name" type="text" name="first_name" class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }" required>
                    <has-error :form="form" field="first_name"></has-error>
                  </div>

                  <div class="form-group">
                    <label for="">Apellido</label>
                    <input v-model="form.last_name" type="text" name="last_name" class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }" required>
                    <has-error :form="form" field="last_name"></has-error>
                  </div>

                  <div class="form-group">
                    <label for="">Altura</label>
                    <input v-model="form.height" type="number" min="0" step=".01" name="height" class="form-control" :class="{ 'is-invalid': form.errors.has('height') }" required>
                    <has-error :form="form" field="height"></has-error>
                  </div>


                  <div class="form-group">
                    <label for="">Peso</label>
                    <input v-model="form.weight" type="number" min="0" step=".01" name="weight" class="form-control" :class="{ 'is-invalid': form.errors.has('weight') }" required>
                    <has-error :form="form" field="weight"></has-error>
                  </div>

                  <div class="form-group">
                    <label>Sexo</label>
                    <select class="form-control" name="sex" v-model="form.sex" :class="{ 'is-invalid': form.errors.has('sex') }" required>
                      <option value="Masculino"> Masculino</option>
                      <option value="Femenino"> Femenino</option>
                    </select>
                    <has-error :form="form" field="sex"></has-error>
                  </div>

                  <div class="form-group">
                    <label for="">Fecha de nacimiento</label>
                    <input v-model="form.birth" type="date"  name="birth" class="form-control" :class="{ 'is-invalid': form.errors.has('birth') }" required>
                    <has-error :form="form" field="birth"></has-error>
                  </div>

                  <div class="form-group">
                    <label>Dirección</label>
                    <textarea v-model="form.address" name="address" class="form-control" :class="{ 'is-invalid': form.errors.has('address') }" required>
                    </textarea>

                    <has-error :form="form" field="address"></has-error>
                  </div>

                  <div class="form-group">
                    <label>Ciudad</label>
                    <input v-model="form.city" type="text" name="city" class="form-control" :class="{ 'is-invalid': form.errors.has('city') }" required>
                    <has-error :form="form" field="city"></has-error>
                  </div>

                  <div class="form-group">
                    <label>Télefono</label>
                    <input v-model="form.phone" type="tel" name="phone" class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                    <has-error :form="form" field="phone"></has-error>
                  </div>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button v-show="editMode" type="submit" class="btn btn-warning">Actualizar</button>
                  <button v-show="!editMode" type="submit" class="btn btn-success">Crear</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal para las alergias del paciente-->
        <div class="modal fade" id="addAllergie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Alergias del paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                      <form @submit.prevent="guardarAlergiaPaciente()" >

                          <div class="form-group">
                            <label>Paciente</label>
                            <input disabled v-model="form.first_name + ' ' + form.last_name" type="text" name="id_patient"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('id_patient') }" required>
                            <has-error :form="form" field="id_patient"></has-error>
                          </div>

                          <div class="form-group">
                              <label>Alergia</label>
                              <select class="form-control" id="id_alergia" name="id_allergy" v-model="form.id_allergy" :class="{ 'is-invalid': form.errors.has('id_allergy') }" required>
                                  <option v-for="alergia in alergias" :value="alergia.id">{{alergia.name}}</option>
                              </select>
                                <has-error :form="form" field="id_allergy"></has-error>
                          </div>

                          <button v-show="!editAllergie" type="submit" class="btn btn-success">Guardar</button>
                      </form>


                      <table class="table table-sm table-hover table-bordered mt-3">
                        <thead class="thead-dark">
                          <tr>
                            <th>Alergia</th>
                            <th>Detalles</th>
                            <th>Tipo</th>
                            <th>Accion</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="relacion in relaciones" :key="relacion.id">
                            <td>{{relacion.name}}</td>
                            <td>{{relacion.details}}</td>
                            <td>{{relacion.type}}</td>
                            <td>
                              <button @click="eliminarAlergiaPaciente(relacion.pid)" class="btn btn-danger">Eliminar</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>



              </div>
            </div>
          </div>
        </div>

        <!-- Modal para compartir expedientes -->
        <div class="modal fade" id="compartirModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Compartir expediente de paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                      <form @submit.prevent="guardarCompartido()" >

                          <div class="form-group">
                            <label>Paciente</label>
                            <input disabled v-model="form.first_name + ' ' + form.last_name" type="text" name="id_patient"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('id_patient') }" required>
                            <has-error :form="form" field="id_patient"></has-error>
                          </div>

                          <div class="form-group">
                              <label>Medico Asociado</label>
                              <select class="form-control" id="id_asociado" name="id_asociado"   required>
                                  <option v-for="asoc in asociados" :value="asoc.id">{{asoc.name}}</option>
                              </select>
                          </div>

                          <button  type="submit" class="btn btn-success">Guardar</button>
                      </form>


                      <table class="table table-sm table-hover table-bordered mt-3">
                        <thead class="thead-dark">
                          <tr>
                            <th> Medico          </th>
                            <th> Medico asociado </th>
                            <th> Fecha           </th>
                            <th> Accion          </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="compartido in compartidos" :key="compartido.id">
                            <td>{{ compartido.nombreMedico }}</td>
                            <td>{{ compartido.nombreAsociado }}</td>
                            <td>{{ compartido.fecha }}</td>
                            <td>
                              <button @click="eliminarCompartido(compartido.id)" class="btn btn-danger">Eliminar</button>
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
          //Propiedades del componente
          editMode : false,
          editAllergie: false,
          pacientes : {},
          form : new Form({
            id : '',
            first_name : '',
            last_name : '',
            age : '',
            height : '',
            weight : '',
            sex: '',
            birth: '',
            photo: '',
            address: '',
            city: '',
            state: '',
            phone: '',


          }),

          alergias: [],
          doctores: [],
          relaciones: [],
          compartidos: [],
          asociados: [],
        }

      }, methods:{
        eliminarCompartido(id){

          swal.fire({
              title: '¿Estas seguro que deseas eliminar la comparticion del expediente?',
              text: "",
              showCancelButton: true,
              confirmButtonColor: '#3085d0',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Aceptar',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.value) {
                  this.form.delete('api/compartirPaciente/'+id)
                  .then(() => {
                      toast.fire({
                        type: 'success',
                        title: 'comparticion eliminada correctamente'
                      });
                      axios.get('api/compartirPaciente/'+this.form.id).then(({data}) => {
                        this.compartidos = data;
                      })
                  })
                  .catch(() => {
                  })
              }
          })

        },
        guardarCompartido(){
          var asociado = document.getElementById("id_asociado");
          var paciente = this.form.id;

          axios.post('api/compartirPaciente', {id_medico: this.$props.id,id_paciente : paciente, id_asociado: asociado.value })
          .then((response)=>{
              console.log(response);

              toast.fire({
                  type: 'success',
                  title: 'expediente compartido correctamente'
              });

              asociado.value = "";

              axios.get('api/compartirPaciente/'+paciente).then(({data}) => {
                this.compartidos = data;
              })

          }).catch(function (error) {
              console.log(error);
          })


        },
        compartirPaciente(paciente){

          this.form.reset();
          $('#compartirModal').modal('show');
          this.form.fill(paciente);

          axios.get('api/compartirPaciente/'+paciente.id).then(({data}) => {
            this.compartidos = data;
          })

        },
        eliminarAlergiaPaciente(id){
          console.log(id);
          swal.fire({
              title: '¿Estas seguro que deseas eliminar la alergia del paciente?',
              text: "",
              showCancelButton: true,
              confirmButtonColor: '#3085d0',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Aceptar',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.value) {
              this.form.delete('api/alergiasPaciente/'+id)
                  .then(() => {

                    toast.fire({
                        type: 'success',
                        title: 'alergia eliminada correctamente'
                    });

                          axios.get('api/alergiasPaciente/'+this.form.id).then(({data}) => {
                            this.relaciones = data;
                            console.log(data);
                          })

                  })
                  .catch(() => {

                  })
              }
          })

        },
        guardarAlergiaPaciente(){
          var paciente = this.form.id;
          var alergia = document.getElementById("id_alergia");

          axios.post('api/alergiasPaciente', {id_paciente : paciente, id_alergia: alergia.value })
          .then((response)=>{
              console.log(response);

              toast.fire({
                  type: 'success',
                  title: 'alergia guardada correctamente'
              });

              alergia.value = "";

              axios.get('api/alergiasPaciente/'+paciente).then(({data}) => {
                this.relaciones = data;
                console.log(data);
              })

          }).catch(function (error) {
              // Maneja el error si la peticion no se llevo a cabo correctamente
              this.$Progress.fail();
              console.log(error);
          })


        },
        updateUser(){
          this.form.put('api/paciente/'+this.form.id)
          .then(() => {
            Fire.$emit('Afteredited');
            $('#addNew').modal('hide');
            toast.fire({
              type: 'success',
              title: 'Paciente actualizado'
            });
          })
          .catch(() => {
            this.$Progress.fail();
          });
        },

        allergieModal(paciente){
          this.form.reset();
          $('#addAllergie').modal('show');
          this.form.fill(paciente);

          axios.get('api/alergiasPaciente/'+paciente.id).then(({data}) => {
            this.relaciones = data;
            console.log(data);
          })

        },

        updateAllergie(){
          this.form.put('api/alergiasPaciente/'+this.form.id)
          .then(() => {
            Fire.$emit('Afteredited');
            $('#addNewAllergie').modal('hide');
            toast.fire({
              type: 'success',
              title: 'Alergia actualizado'
            });
          })
          .catch(() => {
            this.$Progress.fail();
          });
        },

        createAllergie(){
          this.$Progress.start();
          this.form.post('api/alergiasPaciente')
          .then(() => {
            Fire.$emit('AfterCreated');
            $('#addNewAllergie').modal('hide');
            toast.fire({
              type: 'success',
              title: 'Allergia creado'
            });
            this.$Progress.finish();
          })
          .catch(() => {
          });
        },

        editModal(paciente){
          this.editMode = true;
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(paciente);
        },

        newModal(){
          this.editMode = false;
          this.form.reset();
          $('#addNew').modal('show');
        },

        newAllergie(paciente){
          this.editAllergie = false;
          this.form.reset();
          this.form.fill(paciente);
          $('#addNewAllergie').modal('show');
        },

        deleteUser(id){
          swal.fire({
            title: '¿Estas seguro que deseas eliminar al paciente?',
            text: "Se eliminara el paciente del sistema",
            showCancelButton: true,
            confirmButtonColor: '#3085d0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.value) {
              this.form.delete('api/paciente/'+id)
              .then(() => {

                swal.fire(
                'Eliminado!',
                'Usuario eliminado',
                'success'
                )

                Fire.$emit('Afterdelete');
              })
              .catch(() => {

              })
            }
          })
        },

        loadUsers(){
          axios.get('api/pacientes')
          .then(({data}) => {
            this.pacientes = data
            console.log(data);
          })

          axios.get('api/doctores')
          .then(({data}) => {
            this.doctores = data;
          })

          axios.get('api/alergias')
          .then(({data}) => {
            this.alergias = data
            console.log(data);
          })

          axios.get('api/medicosAsociados')
          .then(({data}) => {
            this.asociados = data
          })
        },

        createUser(){
          this.$Progress.start();
          this.form.post('api/paciente')
          .then(() => {
            Fire.$emit('AfterCreated');
            $('#addNew').modal('hide');
            toast.fire({
              type: 'success',
              title: 'Usuario creado'
            });
            this.$Progress.finish();
          })
          .catch(() => {
          });
        }
      },

      created(){
        this.loadUsers();
        Fire.$on('AfterCreated',() => this.loadUsers());
        Fire.$on('Afterdelete',() => this.loadUsers());
        Fire.$on('Afteredited',() => this.loadUsers());
      },
      props: {
            id: String
        },
    }
  </script>

  <style scoped>

  </style>
