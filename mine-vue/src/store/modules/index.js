/**
 * The file enables `@/store/index.js` to import all vuex modules
 * in a one-shot manner. There should not be any reason to edit this file.
 */

const path = require.context('./', true, /\.js$/)
const modules = {}

path.keys().forEach(key => {
  if (key !== './index.js') {
    modules[key.replace(/(\.\/|\.js)/g, '').replace(/(.+)\//g, '')] = path(key).default
  }
})

export default {
  namespaced: true,
  modules
}
