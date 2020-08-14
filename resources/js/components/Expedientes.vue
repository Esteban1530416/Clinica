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

          <div class="row justify-content-center">
            <div class="col-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>Fecha de nacimiento</th>
                        <th>Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="paciente in pacientes" :key="paciente.id">
                        <td>{{paciente.id}}</td>
                        <td>{{paciente.first_name + " " + paciente.last_name}}</td>
                        <td>{{paciente.sex}}</td>
                        <td>{{paciente.birth}}</td>

                        <td>

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

        loadUsers(){

          axios.get('api/obtenerPacientes/'+this.$props.id)
          .then(({data}) => {
            this.pacientes = data
            console.log(data);
          })

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
