import mainLayout from '@/layout/header-aside'
import util from '@/libs/util.js'

export default {
  namespaced: true,
  state: {
    userinfo: null,
    routers: [],
    roles: [],
    permissions: [],
    quick: []
  },
  mutations: {
    setUserInfo: (state, userinfo) => {
      state.userinfo = userinfo
    },
    setRouters: (state, routers) => {
      state.routers = routers
    },
    setRoles: (state, roles) => {
      state.roles = roles
    },
    setPermissions: (state, permissions) => {
      state.permissions = permissions
    },
    setQuick: (state, quick) => {
      state.quick = quick
    }
  },
  actions: {
    /**
     * 动态生成路由
     * @param { object } context
     */
    async genRouters ({ commit, state }) {
      return new Promise(resolve => {
        const accessedRoutes = filterAsyncRouter(state.routers)
        const menu = util.supplementPath(accessedRoutes)
        commit('store/menu/headerSet', menu, { root: true })
        commit('store/search/init', menu, { root: true })
        commit('setPermissions', accessedRoutes)
        resolve(accessedRoutes)
      })
    }
  }
}

// 遍历后台传来的路由字符串，转换为组件对象
function filterAsyncRouter (asyncRouterMap) {
  return asyncRouterMap.filter(route => {
    if (route.name === 'Dashboard') {
      route.redirect = { name: 'dashboard/index' }
    }
    if (route.type === 'T') {
      route.component = mainLayout
    } else if (route.type === 'C') {
      route.component = null
    } else if (route.type === 'M' && typeof route.component === 'string') {
      route.component = loadView(route.component)
    }
    if (route.type === 'C' && !route.children) {
      return false
    }
    if (route.children != null && route.children && route.children.length) {
      route.children = filterAsyncRouter(route.children)
    }
    return true
  })
}

export const loadView = (view) => { // 路由懒加载
  return (resolve) => require([`@/views/${view}`], resolve)
}
