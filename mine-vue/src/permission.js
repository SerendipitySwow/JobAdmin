import router from './router'
import { Notification } from 'element-ui'

// 进度条
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

import store from '@/store/index'
import util from '@/libs/util.js'

const whiteList = ['login']
const defaultRoutePath = '/dashboard'

/**
 * 路由拦截
 * 权限验证
 */
router.beforeEach(async (to, from, next) => {
  // 进度条
  NProgress.start()
  // 关闭搜索面板
  // store.commit('store/search/set', false)
  const token = util.cookies.get('token')
  if (token && token !== 'undefined') {
    if (to.name === 'login') {
      next({ path: defaultRoutePath })
    } else {
      if (store.state.store.permission.routers.length === 0) {
        store.dispatch('store/account/userinfo').then(() => {
          store.dispatch('store/permission/genRouters').then(accessRoutes => {
            // 挂载菜单
            accessRoutes.push({ path: '*', name: '404', hidden: true, component: (resolve) => require(['@/views/system/error/404'], resolve) })
            router.addRoutes(accessRoutes)
            next({ ...to, replace: true })
          })
        }).catch(() => {
          Notification.error({
            message: '请求用户信息失败，请重试',
            title: '错误',
            duration: 5 * 1000
          })
          store.dispatch('store/user/cancellation', { root: true })
        })
      } else {
        next()
      }
    }
  } else {
    if (whiteList.includes(to.name)) {
      next()
    } else {
      next({ name: 'login', query: { redirect: to.fullPath } })
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
