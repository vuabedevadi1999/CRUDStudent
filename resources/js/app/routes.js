import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './Home'
import Login from './Login'
import StudentList from './StudentList'
import Profile from './Profile'

Vue.use(VueRouter);

export const routes = [
    {
        path: '/',
        name: 'home',
        component : Home,
    },
    {
        path: '/login',
        name: 'login',
        component : Login,
    },
    {
        path: '/students',
        name: 'students',
        component : StudentList,
    },
    {
        path: '/profile',
        name: 'profile',
        component : Profile,
    },
]