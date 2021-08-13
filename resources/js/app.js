
require('./bootstrap');
import Vue from 'vue';
import App from './app/App'
import { routes } from './app/routes';
import VueRouter from 'vue-router';
import { store } from './app/store'
import "./app/validate";
import axios from 'axios';
axios.interceptors.request.use((config)=>{
    let token = store.state.token;
    if (token) {
        config.headers['Accept'] = 'application/json';
        config.headers['Authorization'] = `Bearer ${ token }`;
    }
    return config;
})
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