import util from '@/libs/util'

export default {
  namespaced: true,
  state: {
    // 用户信息
    info: {}
  },
  actions: {
    /**
     * 用户注销时的操作
     * @param {*} param
     */
    cancellation ({ commit, dispatch }) {
      util.cookies.remove('token')
      util.cookies.remove('uuid')
      // 跳转路由
      dispatch('store/user/set', { name: '' }, { root: true })
      commit('store/permission/setRouters', [], { root: true })
      commit('store/permission/setQuick', [], { root: true })
      commit('store/permission/setRoles', [], { root: true })
      commit('store/menu/headerSet', [], { root: true })
      commit('store/page/init', [], { root: true })
      // location.reload()
    },
    /**
     * @description 设置用户数据
     * @param {Object} context
     * @param {*} info info
     */
    async set ({ state, dispatch }, info) {
      // store 赋值
      state.info = info
      // 持久化
      await dispatch('store/db/set', {
        dbName: 'sys',
        path: 'user.info',
        value: info,
        user: true
      }, { root: true })
    },
    /**
     * @description 从数据库取用户数据
     * @param {Object} context
     */
    async load ({ state, dispatch }) {
      // store 赋值
      state.info = await dispatch('store/db/get', {
        dbName: 'sys',
        path: 'user.info',
        defaultValue: {},
        user: true
      }, { root: true })
    }
  }
}
