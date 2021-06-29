import router from './router'
import { Notification } from 'element-ui'
import { request } from '@/api/_service.js'

// 进度条
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

import store from '@/store/index'
import util from '@/libs/util.js'
import { locale } from 'core-js'

const whiteList = ['login']
const defaultRoutePath = '/dashboard'

/**
 * 路由拦截
 * 权限验证
 */
router.beforeEach(async (to, from, next) => {
  await store.dispatch('store/page/isLoaded')
  await store.dispatch('store/size/isLoaded')
  // 进度条
  NProgress.start()
  // 关闭搜索面板
  store.commit('store/search/set', false)
  const token = util.cookies.get('token')
  if (token && token !== 'undefined') {
    if (to.name === 'login') {
      next({ path: defaultRoutePath })
    } else {
      if (store.getters.routers.length === 0) {
        store.dispatch('store/account/userinfo').then(() => {
          store.dispatch('store/permission/genRouters').then(accessRoutes => {
            router.addRoutes(accessRoutes)
            next({ ...to, replace: true })
          })
        }).catch(() => {
          // 尝试刷新token
          request({ url: 'system/refresh', method: 'post' }).then((result) => {
            console.log(result)
            if (result.code === 401) {
              store.dispatch('store/user/cancellation', { root: true })
            } else {
              util.cookies.set('token', result.data.token)
            }
          })
          NProgress.done()
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
