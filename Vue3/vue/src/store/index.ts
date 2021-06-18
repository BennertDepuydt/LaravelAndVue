import Vue from 'vue'
import Vuex from 'vuex'

// @ts-ignore
import auth from './auth.ts';

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
    auth
  },

  strict: debug
});

