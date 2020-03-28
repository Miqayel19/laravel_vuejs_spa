import Home from './components/Home.vue';
import Register from './components/Auth/Register.vue';
import Login from './components/Auth/Login.vue';
// import Dashboard from ‘./components/Dashboard.vue’;
export const routes = [
{
    path: '/',
    meta:{
        requiresAuth:true
    },
    name: 'home',
    component: Home
},
{
    path: '/register',
    name: 'register',
    component: Register,
},
{
    path: '/login',
    name: 'login',
    component: Login,
},
// {
//     path: ‘/dashboard’,
//     name: ‘dashboard’,
//     component: Dashboard,
// }
]