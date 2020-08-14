<template>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Medicinas</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <button class="btn btn-success mb-3" @click="newModal">
              <i class="fas fa-user-injured"></i> Agregar una medicina </button>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-sm table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Presentacion</th>
                                    <th>Detalles</th>
                                    <th>Precio</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="medicina in medicinas" :key="medicina.id">

                                    <td>{{medicina.id}}</td>
                                    <td>{{medicina.name}}</td>
                                    <td>{{medicina.presentation}}</td>
                                    <td>{{medicina.details}}</td>
                                    <td>{{medicina.price}}</td>

                                    <td>
                                    <button @click="editModal(medicina)" class="btn btn-success">Editar</button>
                                    <button @click="deleteMedicine(medicina.id)" class="btn btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 v-show="!editMode" class="modal-title" id="exampleModalLongTitle">Registrar medicina</h5>
                      <h5 v-show="editMode" class="modal-title" id="exampleModalLongTitle">Actualizar medicina</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>

                  <form @submit.prevent="editMode ? updateMedicine() : createMedicine()" >
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nombre</label>
                            <input v-model="form.name" type="text" name="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                            required>
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Presentacion</label>
                            <input v-model="form.presentation" type="text" name="presentation"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('presentation') }"
                            required>
                            <has-error :form="form" field="presentation"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Detalles</label>
                            <input v-model="form.details" type="text" name="details"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('details') }"
                            required>
                            <has-error :form="form" field="details"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Precio</label>
                            <input v-model="form.price" type="number" step="any" name="price" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('price') }"
                            required>
                            <has-error :form="form" field="price"></has-error>
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
    name: "Medicine",

    data(){
        return{
            //Propiedades del componente
            editMode : false,
            medicinas : {},
            form : new Form({
                id : '',
                name : '',
                presentation : '',
                details : '',
                price : ''
            })
        }

    }, methods:{

        updateMedicine(){
            this.form.put('api/medicinas/'+this.form.id)
                .then(() => {
                    Fire.$emit('Afteredited');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Medicina actualizado'
                    });
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        editModal(medicina){
            this.editMode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(medicina);
        },

        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        deleteMedicine(id){
            swal.fire({
                title: '¿Estas seguro que deseas retirar esta medicina?',
                text: "Se eliminara la medicina del sistema",
                showCancelButton: true,
                confirmButtonColor: '#3085d0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                this.form.delete('api/medicinas/'+id)
                    .then(() => {

                            swal.fire(
                                'Eliminado!',
                                'Medicina eliminado',
                                'success'
                            )
                        Fire.$emit('Afterdelete');
                    })
                    .catch(() => {
                    })
                }
            })
        },


        loadMedicinas(){
            axios.get('api/medicinas')
                .then(({data}) => {
                  this.medicinas = data
                  console.log(data);
                })
        },

        createMedicine(){
            this.$Progress.start();
            this.form.post('api/medicinas')
                .then(() => {
                    Fire.$emit('AfterCreated');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Medicina agregada'
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                });
        }
    },

    created(){
        this.loadMedicinas();
        Fire.$on('AfterCreated',() => this.loadMedicinas());
        Fire.$on('Afterdelete',() => this.loadMedicinas());
        Fire.$on('Afteredited',() => this.loadMedicinas());
    }

}

</script>

<style scoped>

</style>
