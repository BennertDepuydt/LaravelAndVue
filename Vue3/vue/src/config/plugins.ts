import Vue from 'vue'

// @ts-ignore
import auth                  from '@websanova/vue-auth/src/v2.js';
// @ts-ignore
import driverAuthBearer      from '@websanova/vue-auth/src/drivers/auth/bearer.js';
// @ts-ignore
import driverHttpAxios       from '@websanova/vue-auth/src/drivers/http/axios.1.x.js';
// @ts-ignore
import driverRouterVueRouter from '@websanova/vue-auth/src/drivers/router/vue-router.2.x.js';

Vue.use(auth, {
    plugins: {
        http: Vue.axios, // Axios
        router: Vue.router,
    },
    drivers: {
        auth: driverAuthBearer,
        http: driverHttpAxios, // Axios
        router: driverRouterVueRouter,
    },
    options: {
        loginData: {url: '/auth/login', method: 'POST', redirect: '', fetchUser: true},
        registerData: {url: '/auth/register', method: 'POST', redirect: '/', fetchUser: true},
        logoutData: {redirect: '/auth/login' },
        refreshData: { enabled: false },
        fetchData: {url: '/users/me', method: 'GET'},
    },
});