import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './Home'
import Login from './Login'
import StudentList from './StudentList'

Vue.use(VueRouter);

export const routes = [
    {
        path: '/',
        component : Home,
    },
    {
        path: '/login',
        component : Login,
    },
    {
        path: '/students',
        component : StudentList,
    },
]