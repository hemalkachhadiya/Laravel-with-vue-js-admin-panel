
# Laravel-with-vue-js-admin-panel

Now a day many clients want single-page applications for their projects and Vue js is one of the good javascript frameworks for it. And main point is vue js easily integrate with laravel.

Many times more difficult to create vue js in laravel for the admin panel that required more work and lots of confusion for it so here we create a demo for easy and proper integration of laravel with vue js.


## Installation

```cmd
composer install
npm install
php artisan key:generate
```
import database in phpmyadmin.

## Code explanation 

in resources/js create app.js and add the below code to create a vue app
```javascript
require('./bootstrap');


window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './router';
const router = new VueRouter({
    routes
});
import App from './App.vue';
import moment from 'moment';
import store from './store';


router.beforeEach((to, from, next) => {
    axios.get('auth/init').then(response => {
        var user = response.data.user;
        if (to.fullPath !== "/login" && to.fullPath !== "/register") {
            if (user !== null) {
                next();
            } else {
                router.push('/login');
            }
        } else {
            if (user == null) {
                next();
            } else {
                router.push('/dashboard');
            }
        }
    }).catch(error => {})
})
new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');
```
after that create the main component of vue
```
<template>
           <router-view :app="this"/>
</template>
<script>
import layouts from './components/layouts.vue';
export default {
  components: { layouts },
    name: 'app',
    	data(){
            return{
            }
		},
};
</script>
<style>
</style>
```
create route.js at the same directory.
```
import Dashboard from "./views/Dashboard"
import Layouts from "./components/layouts"
import Login from "./components/Login"
import Register from "./components/Register"
import Uderdevelopment from "./components/Uderdevelopment"
export default [{
        // mode: 'history',
        // base: 'project/aplarva',
        path: '/',
        component: Layouts,
        name: 'layouts',
        redirect: {
            name: 'dashboard'
        },
        children: [{
                path: 'dashboard',
                component: Dashboard,
                name: 'dashboard',
            },
        ]
    },
    {
        path: '/login',
        component: Login,
        name: 'login',

    },
    {
        path: '/register',
        component: Register,
        name: 'register'
    },
    {
        path: '*',
        name: 'Uderdevelopment',
        component: Uderdevelopment
    }

];
```
login and register for authentication and dashboard for dashboard page.

```javascript
{
        path: '*',
        name: 'Uderdevelopment',
        component: Uderdevelopment
}

```
for 404 pages or undefine route 

components directory only for creating components but view directory for creating one page for URL.
view file has many components but components have only one at a time in per file so that thing make code more clear for development.