const _import = require('@/libs/util.import.' + process.env.NODE_ENV)

export default [
  {
    path: 'dashboard',
    name: 'dashboard/index',
    meta: {
      title: '首页',
      auth: true
    },
    component: _import('system/index')
  },
  // 系统 前端日志
  {
    path: 'log',
    name: 'log',
    meta: {
      title: '前端日志',
      auth: true
    },
    component: _import('system/log')
  },
  // 刷新页面 必须保留
  {
    path: 'refresh',
    name: 'refresh',
    hidden: true,
    component: _import('system/function/refresh')
  },
  // 页面重定向 必须保留
  {
    path: 'redirect/:route*',
    name: 'redirect',
    hidden: true,
    component: _import('system/function/redirect')
  }
]
