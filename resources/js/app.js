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