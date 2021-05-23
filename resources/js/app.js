/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import vuetify from "./plugins/vuetify";
import store from "./store";
import Confirm from './plugins/confirm/index';

import VueToast from 'vue-toast-notification';
// Import one of the available themes
import 'vue-toast-notification/dist/theme-default.css';
// import 'vue-toast-notification/dist/theme-sugar.css';

window.axios.defaults.headers.common = {
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  'X-Requested-With': 'XMLHttpRequest'
};

Vue.use(VueToast);

Vue.use(VueRouter);
Vue.use(Confirm, {
  vuetify,
  buttonTrueText: 'Accept',
  buttonFalseText: 'Cancel',
  buttonTrueColor: '#3A833C',
  buttonFalseColor: '#303030',
  buttonTrueFlat: true,
  buttonFalseFlat: true,
  color: 'primary',
  icon: '',
  title: '',
})

import App from "./components/App";
import HomeComponent from "./components/HomeComponent";

const routes = [
    {
        name: 'home',
        path: '/',
        component: HomeComponent,
    }
]

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue(Vue.util.extend({ router, vuetify, store }, App)).$mount('#app');
