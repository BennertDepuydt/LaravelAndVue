import Vue from "vue";
// @ts-ignore
import VueAxios from "vue-axios";
import axios from "axios";
import URL from "./globals"
import router from './router'

axios.defaults.baseURL = URL

//global API handler
axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response === undefined) {
        router.push({name: 'serverError'})
    }

    if (error.response.status === 502) {
        router.push({name: 'serverError'})
    }

    return Promise.reject(error);
});

Vue.use(VueAxios, axios);
