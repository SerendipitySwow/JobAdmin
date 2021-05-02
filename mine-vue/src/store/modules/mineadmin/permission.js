import mainLayout from '@/layout/header-aside'

export default {
  namespaced: true,
  state: { routers: [], userinfo: null, roles: [], permissions: [] },
  mutations: {
    setRouters: (state, routers) => {
      state.routers = routers
    },
    setUserInfo: (state, userinfo) => {
      state.userinfo = userinfo
    },
    setRoles: (state, roles) => {
      state.roles = roles
    },
    setPermissions: (state, permissions) => {
      state.permissions = permissions
    }
  },
  actions: {
    /**
     * 动态生成路由
     * @param { object } context
     */
    async genRouters ({ state, commit }) {
      return new Promise(resolve => {
        const accessedRoutes = filterAsyncRouter(state.routers)
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
