import Vue from 'vue'
import Vuex from 'vuex'

import store from './modules'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    store
  }
})
