import mainLayout from '@/layout'
import util from '@/libs/util.js'

export default {
  namespaced: true,
  state: {
    userinfo: null,
    routers: [],
    roles: [],
    permissions: [],
    quick: [],
    codes: []
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
    },
    setCodes: (state, codes) => {
      state.codes = codes
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
        console.log(accessedRoutes)
        const menu = util.supplementPath(accessedRoutes)
        menu.unshift({ title: '首页', path: '/', name: 'dashboard', icon: 'home' })
        accessedRoutes.push({
          path: '*',
          name: '404',
          hidden: true,
          component: (resolve) => require(['@/views/public/error/404'], resolve)
        })
        commit('store/menu/headerSet', menu, { root: true })
        commit('store/page/init', menu, { root: true })
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
    if (route.type === 'B') {
      return false
    }

    if (route.hidden) {
      return false
    }

    if (route.type === 'T') {
      route.component = mainLayout
    } else if (route.type === 'C') {
      route.component = loadView('public/index/container')
    } else if (route.type === 'M' && typeof route.component === 'string' && route.component !== null) {
      route.component = loadView(route.component)
    }

    if (!/^http:\/\/|https:\/\//.test(route.path)) {
      route.path = '/' + route.path
    }

    if (route.type === 'C' && !route.children) {
      return false
    }

    if (route.type === 'M') {
      route.children = undefined
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
