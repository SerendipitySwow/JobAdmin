import Vue from 'vue'
import VueRouter from 'vue-router'
import { Notification } from 'element-ui'

// 进度条
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

import store from '@/store/index'
import util from '@/libs/util.js'

// 路由数据
import routes from './routes'
import { uniqueId } from 'lodash'

// fix vue-router NavigationDuplicated
const VueRouterPush = VueRouter.prototype.push
VueRouter.prototype.push = function push (location) {
  return VueRouterPush.call(this, location).catch(err => err)
}
const VueRouterReplace = VueRouter.prototype.replace
VueRouter.prototype.replace = function replace (location) {
  return VueRouterReplace.call(this, location).catch(err => err)
}

Vue.use(VueRouter)

// 导出路由 在 main.js 里使用
const router = new VueRouter({
  mode: 'history',
  routes
})

const whiteList = ['login']
const defaultRoutePath = '/dashboard'

/**
 * 路由拦截
 * 权限验证
 */
router.beforeEach(async (to, from, next) => {
  // 确认已经加载多标签页数据 https://github.com/d2-projects/d2-admin/issues/201
  await store.dispatch('store/page/isLoaded')
  // 确认已经加载组件尺寸设置 https://github.com/d2-projects/d2-admin/issues/198
  await store.dispatch('store/size/isLoaded')
  // 进度条
  NProgress.start()
  // 关闭搜索面板
  store.commit('store/search/set', false)
  const token = util.cookies.get('token')
  if (token && token !== 'undefined') {
    if (to.name === 'login') {
      next({ path: defaultRoutePath })
      NProgress.done()
    } else {
      if (store.state.store.permission.routers.length === 0) {
        store.dispatch('store/account/userinfo').then(() => {
          store.dispatch('store/permission/genRouters').then(accessRoutes => {
            // 挂载菜单
            console.log(accessRoutes)
            store.commit('store/menu/headerSet', supplementPath(accessRoutes))
            // 初始化菜单搜索功能
            store.commit('store/search/init', supplementPath(accessRoutes))
            router.addRoutes(accessRoutes)
            next({ ...to, replace: true })
          })
        }).catch(() => {
          Notification.error({
            message: '请求用户信息失败，请重试',
            title: '错误',
            duration: 5 * 1000
          })
          util.cookies.remove('token')
          util.cookies.remove('uuid')
          // 清空 vuex 用户信息
          store.dispatch('store/user/set', {}, { root: true })
          // 清空动态路由信息
          store.commit('store/permission/setRouters', [], { root: true })
          store.commit('store/permission/setPermissions', [], { root: true })
          // 跳转路由
          router.push({ name: 'login' })
        })
      } else {
        next()
        NProgress.done()
      }
    }
  } else {
    if (whiteList.includes(to.name)) {
      next()
      NProgress.done()
    } else {
      next({ name: 'login', query: { redirect: to.fullPath } })
      NProgress.done()
    }
  }
})

router.afterEach(to => {
  // 进度条
  NProgress.done()
  // 多页控制 打开新的页面
  store.dispatch('store/page/open', to)
  // 更改标题
  util.title(to.meta.title)
})

/**
 * @description 给菜单数据补充上 path 字段
 * @description https://github.com/d2-projects/d2-admin/issues/209
 * @param {Array} menu 原始的菜单数据
 */
function supplementPath (menu) {
  return menu.map(e => ({
    ...e,
    path: e.path || uniqueId('d2-menu-empty-'),
    title: e.title,
    icon: e.icon,
    ...e.children ? {
      children: supplementPath(e.children)
    } : {}
  }))
}

export default router
