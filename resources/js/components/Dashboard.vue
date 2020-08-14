<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Son tarjetas coloridas con los numeros globales del sistema -->

                            <div class="row">
                                <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1' || this.$props.tipo == '2' ">

                                      <div class="small-box bg-primary">
                                      <div class="inner">
                                          <center> <h3>{{ totalalergias }}</h3>

                                          <p>Alergias</p> </center>
                                      </div>
                                      <div class="icon">
                                          <i class="ion ion-bag"></i>
                                          <span class="iconify" data-icon="fa:user"></span>
                                      </div>
                                      </div>
                                  </div>


                                    <!-- ./col -->
                                    <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1' || this.$props.tipo == '2' ">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                        <div class="inner">
                                          <center>  <h3>{{ totalenfermedades }}</h3>

                                            <p>Enfermedades</p> </center>
                                        </div>
                                        <div class="icon">
                                            <span class="iconify" data-icon="mdi:bacteria" data-inline="false"></span>
                                        </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1' || this.$props.tipo == '2' || this.$props.tipo == '4'">
                                        <!-- small box -->
                                        <div class="small-box bg-danger">
                                        <div class="inner">
                                            <center> <h3> {{totalcitas}} </h3>

                                            <p>Citas</p> </center>
                                        </div>
                                        <div class="icon">
                                            <span class="iconify" data-icon="ant-design:calendar-filled" data-inline="false"></span>
                                        </div>

                                        </div>
                                    </div>

                                    <!-- ./col -->
                                    <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1' || this.$props.tipo == '2' ">
                                        <!-- small box -->
                                        <div class="small-box bg-indigo">
                                        <div class="inner">
                                          <center>  <h3> {{ totalpacientes }} </h3>

                                            <p>Pacientes</p> </center>
                                        </div>
                                        <div class="icon">
                                            <span class="iconify" data-icon="medical-icon:i-outpatient" data-inline="false"></span>
                                        </div>

                                        </div>
                                    </div>
                                    <!-- ./col -->

                                    <!-- ./col -->
                            </div>



                            <div class="row">

                                    <!-- ./col -->
                                    <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1' || this.$props.tipo == '2' ">
                                        <!-- small box -->
                                        <div class="small-box bg-success">
                                        <div class="inner">
                                            <center> <h3>{{ totalmedicinas }}</h3>

                                            <p>Medicinas</p> </center>
                                        </div>
                                        <div class="icon">
                                            <span class="iconify" data-icon="mdi:bacteria" data-inline="false"></span>
                                        </div>

                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1'">

                                            <div class="small-box bg-info">
                                            <div class="inner">
                                                <center> <h3>{{totalUsuarios}}</h3>

                                                <p>Usuarios</p> </center>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-bag"></i>
                                                <span class="iconify" data-icon="fa:user"></span>
                                            </div>
                                            </div>
                                        </div>

                                    <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1' || this.$props.tipo == '4'">
                                        <!-- small box -->
                                        <div class="small-box bg-warning">
                                        <div class="inner">
                                            <center> <h3> {{ totalPagos }} </h3>

                                            <p>Pagos</p> </center>
                                        </div>
                                        <div class="icon">
                                            <span class="iconify" data-icon="medical-icon:i-outpatient" data-inline="false"></span>
                                        </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-6" v-show="this.$props.tipo == '1' || this.$props.tipo == '3'">
                                        <!-- small box -->
                                        <div class="small-box bg-success">
                                        <div class="inner">
                                            <center> <h3> {{ totalcomaprtidos }} </h3>

                                            <p>Expedientes compartidos</p> </center>
                                        </div>
                                        <div class="icon">
                                            <span class="iconify" data-icon="medical-icon:i-outpatient" data-inline="false"></span>
                                        </div>

                                        </div>
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
        //Nombre del componente
        name: "Dashboard",
        //Propiedades del componente
        data(){
            return {
                totalUsuarios : 0,
                totalcitas : 0,
                totalenfermedades : 0,
                totalpacientes : 0,
                totalalergias : 0,
                totalmedicinas: 0,
                totalPagos: 0,
                totalcomaprtidos: 0
            }
        },
        created() {
            this.obtenerDatos();
            console.log("TIPO " + this.$props.tipo);
        },
        props: {
              tipo: String,
              id: String
        },
        methods: {
            obtenerDatos() {
                axios.get("/api/totalusuarios").then(resp => { this.totalUsuarios = resp.data });
                axios.get("/api/totalcitas").then(resp => { this.totalcitas = resp.data });
                axios.get("/api/totalenfermedades").then(resp => { this.totalenfermedades = resp.data });
                axios.get("/api/totalpacientes").then(resp => { this.totalpacientes = resp.data });
                axios.get("/api/totalalergias").then(resp => { this.totalalergias = resp.data });
                axios.get("/api/totalmedicinas").then(resp => { this.totalmedicinas = resp.data });
                axios.get("/api/totalpagos").then(resp => { this.totalPagos = resp.data });
                axios.get("/api/totalcomaprtidos/"+this.$props.id).then(resp => { this.totalcomaprtidos = resp.data });
            }
        }

    }
</script>

<style scoped>

</style>
