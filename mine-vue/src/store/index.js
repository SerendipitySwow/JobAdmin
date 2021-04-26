import Vue from 'vue'
import Vuex from 'vuex'

import d2admin from './modules'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    d2admin
  }
})
