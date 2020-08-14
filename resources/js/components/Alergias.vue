<template>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Alergias</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <button class="btn btn-success mb-3" @click="newModal">
              <i class="fas fa-user-injured"></i> Agregar una alergia </button>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-sm table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Detalles</th>
                                    <th>Tipo</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="alergia in alergias" :key="alergia.id">

                                    <td>{{alergia.id}}</td>
                                    <td>{{alergia.name}}</td>
                                    <td>{{alergia.details}}</td>
                                    <td>{{alergia.type}}</td>

                                    <td>
                                    <button @click="editModal(alergia)" class="btn btn-success">Editar</button>
                                    <button @click="deleteAllergie(alergia.id)" class="btn btn-danger">Eliminar</button>
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
                      <h5 v-show="!editMode" class="modal-title" id="exampleModalLongTitle">Registrar alergia</h5>
                      <h5 v-show="editMode" class="modal-title" id="exampleModalLongTitle">Actualizar alergia</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>

                  <form @submit.prevent="editMode ? updateAllergie() : createAllergie()" >
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nombre</label>
                            <input v-model="form.name" type="text" name="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                            required>
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Detalles</label>
                            <input v-model="form.details" type="text" name="details"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('details') }"
                            required>
                            <has-error :form="form" field="details"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Tipo</label>
                            <input v-model="form.type" type="text" name="type"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }"
                            required>
                            <has-error :form="form" field="type"></has-error>
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
            alergias : {},
            form : new Form({
                id : '',
                name : '',
                details : '',
                type : ''
            })
        }

    }, methods:{

        updateAllergie(){
            this.form.put('api/alergias/'+this.form.id)
                .then(() => {
                    Fire.$emit('Afteredited');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Alergia actualizado'
                    });
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        editModal(alergia){
            this.editMode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(alergia);
        },

        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteAllergie(id){
            swal.fire({
                title: '¿Estas seguro que deseas retirar esta alergia?',
                text: "Se eliminara la alergia del sistema",
                showCancelButton: true,
                confirmButtonColor: '#3085d0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                this.form.delete('api/alergias/'+id)
                    .then(() => {

                            swal.fire(
                                'Eliminado!',
                                'Alergia eliminada',
                                'success'
                            )
                        Fire.$emit('Afterdelete');
                    })
                    .catch(() => {
                    })
                }
            })
        },


        loadAllergies(){
            axios.get('api/alergias')
                .then(({data}) => {
                  this.alergias = data
                  console.log(data);
                })
        },

        createAllergie(){
            this.$Progress.start();
            this.form.post('api/alergias')
                .then(() => {
                    Fire.$emit('AfterCreated');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Alergia agregada'
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                });
        }
    },

    created(){
        this.loadAllergies();
        Fire.$on('AfterCreated',() => this.loadAllergies());
        Fire.$on('Afterdelete',() => this.loadAllergies());
        Fire.$on('Afteredited',() => this.loadAllergies());
    }

}

</script>

<style scoped>

</style>
