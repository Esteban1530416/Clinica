<template>

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Usuarios</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <button class="btn btn-success mb-3" @click="newModal"> <i class="fas fa-user-plus"></i> Crear nuevo usuario</button>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-sm table-hover table-bordered" id="table_id">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Tipo de usuario</th>
                                        <th>Creado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{user.id}}</td>
                                        <td>{{user.name}}</td>
                                        <td>{{user.email}}</td>
                                        <td>
                                            <span v-if="user.type == '1'" class="tag tag-success">
                                                Admin
                                            </span>
                                            <span v-else-if="user.type == '2'" class="tag tag-success">
                                                Medico Principal
                                            </span>
                                            <span v-else-if="user.type == '3'" class="tag tag-success">
                                                Medico asociado
                                            </span>
                                            <span v-else-if="user.type == '4'" class="tag tag-success">
                                                Secretaria
                                            </span>
                                            </td>
                                        <td><span class="tag tag-success">{{user.created_at}}</span></td>
                                        <td>
                                        <button @click="editModal(user)" class="btn btn-success">Editar</button>
                                        <button @click="deleteUser(user.id)" class="btn btn-danger">Eliminar</button>
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
                          <h5 v-show="!editMode" class="modal-title" id="exampleModalLongTitle">Registrar usuario</h5>
                          <h5 v-show="editMode" class="modal-title" id="exampleModalLongTitle">Actualizar usuario</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>

                      <form @submit.prevent="editMode ? updateUser() : createUser()" >
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <input v-model="form.email" type="text" name="email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Tipo</label>
                                <select class="form-control" name="type" v-model="form.type" :class="{ 'is-invalid': form.errors.has('type') }">

                                    <option value="1">Admin</option>
                                    <option value="2">Medico Principal</option>
                                    <option value="3">Medico Asociado</option>
                                    <option value="4">Secretari@</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Contraseña</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
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
        name: "User",
        data(){
            return{
                editMode : false,
                users : {},
                form : new Form({
                    id : '',
                    name : '',
                    email : '',
                    type : '',
                    password : '',
                })
            }
        },
        methods:{
            updateUser(){
                this.form.put('api/user/'+this.form.id)
                    .then(() => {
                        Fire.$emit('Afteredited');
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Usuario actualizado',
                            'Usuario actualizado con exito',
                            'success'
                        )
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },
            editModal(user){
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteUser(id){
                swal.fire({
                    title: '¿Estas seguro que quieres eliminar al usuario?',
                    text: "Se eliminara el usuario del sistema",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d0',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                    this.form.delete('api/user/'+id)
                        .then(() => {

                                swal.fire(
                                    'Usuario eliminado',
                                    'Usuario eliminado con exito',
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
                axios.get('api/user')
                    .then(({data}) => (this.users = data.data))
            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
                    .then(() => {
                        Fire.$emit('AfterCreated');
                        $('#addNew').modal('hide');

                        swal.fire(
                            'Usuario creado',
                            'Usuario creado con exito',
                            'success'
                        )

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
        }
    }
</script>

<style scoped>

</style>
