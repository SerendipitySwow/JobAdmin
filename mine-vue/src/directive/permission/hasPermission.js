import store from '@/store'

export default {
  inserted (el, binding, vnode) {
    const { value } = binding
    const superAdmin = '*'
    const permissions = store.getters && store.getters.codes

    if (value && value instanceof Array && value.length > 0) {
      const permissionFlag = value

      const hasPermissions = permissions.some(permission => {
        return superAdmin === permission || permissionFlag.includes(permission)
      })

      if (!hasPermissions) {
        el.parentNode && el.parentNode.removeChild(el)
      }
    } else {
      throw new Error('缺少要检查的菜单代码')
    }
  }
}
