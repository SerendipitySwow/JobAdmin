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
  // 确认已经加载多标签页数据 https://github.com/d2-projects/d2-admin/issues/201
  // await store.dispatch('store/page/isLoaded')
  // 确认已经加载组件尺寸设置 https://github.com/d2-projects/d2-admin/issues/198
  // await store.dispatch('store/size/isLoaded')
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
          util.cookies.remove('token')
          util.cookies.remove('uuid')
          // 清空 vuex 用户信息
          store.dispatch('store/user/set', {}, { root: true })
          // 清空动态路由信息
          store.commit('store/permission/setRoles', [], { root: true })
          store.commit('store/permission/setPermissions', [], { root: true })
          store.commit('store/permission/setRouters', [], { root: true })
          store.commit('store/permission/setQuick', [], { root: true })
          // 跳转路由
          router.push({ name: 'login' })
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
