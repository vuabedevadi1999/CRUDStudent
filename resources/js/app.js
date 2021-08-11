
require('./bootstrap');

import Vue from 'vue';
import App from './app/App'
import { routes } from './app/routes';
import VueRouter from 'vue-router';
import { store } from './app/store'
import "./app/validate";
// import { ValidationObserver } from 'vee-validate';
// import { ValidationProvider } from 'vee-validate/dist/vee-validate.full.esm';
// Vue.component('ValidationProvider',ValidationProvider);
// Vue.component('ValidationObserver',ValidationObserver);
var auth_token = store.state.token;
window.axios = require('axios');
window.axios.defaults.headers.common ={'Authorization': `Bearer ${auth_token}`};
Vue.component('pagination', require('laravel-vue-pagination'));
const router = new VueRouter({
    routes,
    mode : 'history',
});

const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    render: app => app(App),
});
