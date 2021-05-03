import util from '@/libs/util'
import router from '@/router'

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
      router.push({ name: 'login' })
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
