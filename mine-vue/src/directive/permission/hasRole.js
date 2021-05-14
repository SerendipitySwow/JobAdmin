/**
 * 角色权限处理
 * Copyright (c) 2019 ruoyi
 */

import store from '@/store'

export default {
  inserted (el, binding, vnode) {
    const { value } = binding
    const superAdmin = 'super_admin'
    const roles = store.getters && store.getters.roles

    if (value && value instanceof Array && value.length > 0) {
      const roleFlag = value

      const hasRole = roles.some(role => {
        return superAdmin === role || roleFlag.includes(role)
      })

      if (!hasRole) {
        el.parentNode && el.parentNode.removeChild(el)
      }
    } else {
      throw new Error('缺少要检查的角色代码')
    }
  }
}
