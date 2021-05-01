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
            console.log(accessRoutes)
            router.addRoute(accessRoutes)
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

export default router
