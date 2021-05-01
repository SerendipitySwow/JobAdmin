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
        // accessedRoutes.push({ path: '*', redirect: '/404', hidden: true })
        commit('setPermissions', accessedRoutes)
        resolve(accessedRoutes)
      })
    }
  }
}

// 遍历后台传来的路由字符串，转换为组件对象
function filterAsyncRouter (asyncRouterMap) {
  return asyncRouterMap.filter(route => {
    if (route.type === 'T') {
      route.component = mainLayout
    }
    // } else if (route.type === 1) {
    //   route.component = loadView(route.module, route.component)
    // } else if (route.type === 2 && typeof route.component === 'string') {
    //   route.component = loadView(route.module, route.component)
    // }
    // if (route.children != null && route.children && route.children.length) {
    //   route.children = filterAsyncRouter(route.children)
    // } else if (typeof route.component === 'string') {
    //   route.component = loadView(route.module, route.component)
    // }
    return true
  })
}

export const loadView = (module, view) => { // 路由懒加载
  return (resolve) => require([`@/views/${module}/${view}`], resolve)
}
