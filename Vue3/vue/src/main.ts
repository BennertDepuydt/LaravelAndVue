import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './axios'
import './config/plugins'

//bootstrap
// @ts-ignore
import BootstrapVue, {IconsPlugin} from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// @ts-ignore
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import 'bootstrap/scss/bootstrap.scss'

//i18n locales
// @ts-ignore
import VueI18n from 'vue-i18n'

//Font-Awesome
// @ts-ignore
import {library} from "@fortawesome/fontawesome-svg-core";
// @ts-ignore
import {fas} from "@fortawesome/free-solid-svg-icons";
// @ts-ignore
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

//notifications
import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

//datetime
// @ts-ignore
import { Datetime } from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'

//slider
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/material.css'

//router
import {VueRouter} from "vue-router/types/router";

declare module 'vue/types/vue' {
  interface VueConstructor {
    router: VueRouter, // needed for vue-auth
  }
}

Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)
Vue.use(VueI18n)
library.add(fas);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(VueToast);
Vue.use(Datetime)
Vue.component('datetime', Datetime);
Vue.component('VueSlider', VueSlider)


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
