require('./bootstrap');

window.Vue = require('vue').default;



// import package
import select2 from 'select2';
import Swal from 'sweetalert2';
import VueRouter from 'vue-router';
import './plugins/particles.js';
import axios from 'axios';
import Lodash from 'lodash';





const particlesJS = window.particlesJS;



// import css

import '../css/app.css';
import '../css/listing.css';

// definisikan package

window.select2 = select2;
window.Swal = Swal;
window._ = Lodash;

//import components

import App from './pages/App';
import router from './router';

axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/v1`;

import Paginate from './components/Paginate';
import Vue from 'vue';

Vue.use(VueRouter);
Vue.component('paginate', Paginate);

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});