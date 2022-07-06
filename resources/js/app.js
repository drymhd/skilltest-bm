require('./bootstrap');

window.Vue = require('vue').default;


// import package
import select2 from 'select2';
import Swal from 'sweetalert2';
import VueRouter from 'vue-router';
import './plugins/particles.js';


const particlesJS = window.particlesJS;



// import css

import '../css/app.css';

// definisikan package

window.select2 = select2;
window.Swal = Swal;

//import components

import App from './pages/App';
import router from './router';

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});