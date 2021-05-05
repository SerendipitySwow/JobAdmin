import mainLayout from '@/layout'

// 由于懒加载页面太多的话会造成webpack热更新太慢，所以开发环境不使用懒加载，只有生产环境使用懒加载
const _import = require('@/libs/util.import.' + process.env.NODE_ENV)

/**
 * 在主框架内显示
 */
const frameIn = [
  {
    path: '/',
    redirect: { name: 'dashboard/index' },
    name: 'dashboard',
    component: mainLayout,
    children: [
      // 首页
      {
        path: '/dashboard',
        name: 'dashboard/index',
        meta: {
          title: '首页',
          auth: true
        },
        component: _import('public/index')
      },
      // 系统 前端日志
      {
        path: 'log',
        name: 'log',
        meta: {
          title: '前端日志',
          auth: true
        },
        component: _import('public/log')
      },
      // 刷新页面 必须保留
      {
        path: 'refresh',
        name: 'refresh',
        hidden: true,
        component: _import('public/function/refresh')
      },
      // 页面重定向 必须保留
      {
        path: 'redirect/:route*',
        name: 'redirect',
        hidden: true,
        component: _import('public/function/redirect')
      }
    ]
  },
  // 登录
  {
    path: '/login',
    name: 'login',
    component: _import('system/login')
  }
]

// 重新组织后导出
export default [
  ...frameIn
]
