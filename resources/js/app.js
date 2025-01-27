
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter);

//vform
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

//moment js
import moment from "moment";

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});

import swal from 'sweetalert2';
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

window.Fire = new Vue();

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard').default },
    { path: '/user', component: require('./components/User').default },
    { path: '/pacientes', component: require('./components/Pacientes').default },
    { path: '/citas', component: require('./components/Citas').default },
    { path: '/enfermedades', component: require('./components/Enfermedades').default },
    { path: '/medicinas', component: require('./components/Medicinas').default },
    { path: '/alergias', component: require('./components/Alergias').default },
    { path: '/listacitas', component: require('./components/ListaCitas').default },
    { path: '/expedientes', component: require('./components/Expedientes').default },
    { path: '/pagos', component: require('./components/Pagos').default }
];

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter({
    mode :'history',
    routes // short for `routes: routes`
});

Vue.filter('mydate',function (created) {
   return moment(created).format('MMM Do YY');
});

const app = new Vue({
    el: '#app',
    router
});
