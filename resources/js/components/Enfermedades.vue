<template>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Enfermedades</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <button class="btn btn-success mb-3" @click="newModal">
              <i class="fas fa-user-injured"></i> Agregar una enfermedad </button>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-sm table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Causa</th>
                                    <th>Modo de transmisión</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="enfermedad in enfermedades" :key="enfermedad.id">

                                    <td>{{enfermedad.id}}</td>
                                    <td>{{enfermedad.name}}</td>
                                    <td>{{enfermedad.type}}</td>
                                    <td>{{enfermedad.causative}}</td>
                                    <td>{{enfermedad.mode_of_transmision}}</td>

                                    <td>
                                    <button @click="editModal(enfermedad)" class="btn btn-success">Editar</button>
                                    <button @click="deleteDisease(enfermedad.id)" class="btn btn-danger">Eliminar</button>
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
                      <h5 v-show="!editMode" class="modal-title" id="exampleModalLongTitle">Registrar enfermedad</h5>
                      <h5 v-show="editMode" class="modal-title" id="exampleModalLongTitle">Actualizar enfermedad</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>

                  <form @submit.prevent="editMode ? updateDisease() : createDisease()" >
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nombre</label>
                            <input v-model="form.name" type="text" name="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                            required>
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Tipo</label>
                            <input v-model="form.type" type="text" name="type"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }"
                            required>
                            <has-error :form="form" field="type"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Causa</label>
                            <input v-model="form.causative" type="text" name="causative"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('causative') }"
                            required>
                            <has-error :form="form" field="causative"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Modo de transmisión</label>
                            <input v-model="form.mode_of_transmision" type="text" name="mode_of_transmision"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('mode_of_transmision') }"
                            required>
                            <has-error :form="form" field="mode_of_transmision"></has-error>
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
    </div>

</div>

</template>

<script>

export default {
    name: "Disease",

    data(){
        return{
            //Propiedades del componente
            editMode : false,
            enfermedades : {},
            form : new Form({
                id : '',
                name : '',
                type : '',
                causative : '',
                mode_of_transmision : ''
            })
        }

    }, methods:{

        updateDisease(){
            this.form.put('api/enfermedades/'+this.form.id)
                .then(() => {
                    Fire.$emit('Afteredited');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Enfermedad actualizado'
                    });
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        editModal(enfermedad){
            this.editMode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(enfermedad);
        },

        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteDisease(id){
            swal.fire({
                title: '¿Estas seguro que deseas retirar esta enfermedad?',
                text: "Se eliminara la enfermedad del sistema",
                showCancelButton: true,
                confirmButtonColor: '#3085d0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                this.form.delete('api/enfermedades/'+id)
                    .then(() => {

                            swal.fire(
                                'Eliminado!',
                                'Enfermedad eliminado',
                                'success'
                            )
                        Fire.$emit('Afterdelete');
                    })
                    .catch(() => {
                    })
                }
            })
        },


        loadDiseases(){
            axios.get('api/enfermedades')
                .then(({data}) => {
                  this.enfermedades = data
                  console.log(data);
                })
        },

        createDisease(){
            this.$Progress.start();
            this.form.post('api/enfermedades')
                .then(() => {
                    Fire.$emit('AfterCreated');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Enfermedad agregada'
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                });
        }
    },

    created(){
        this.loadDiseases();
        Fire.$on('AfterCreated',() => this.loadDiseases());
        Fire.$on('Afterdelete',() => this.loadDiseases());
        Fire.$on('Afteredited',() => this.loadDiseases());
    }

}

</script>

<style scoped>

</style>
