import Vue from 'vue'
import Vuex from 'vuex'

import store from './modules'
import getters from './getters'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    store
  },
  getters
})
