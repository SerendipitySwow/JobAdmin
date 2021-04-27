import { Message, MessageBox } from 'element-ui'
import util from '@/libs/util.js'
import router from '@/router'
import { login } from '@/api/system/login.js'

export default {
  namespaced: true,
  actions: {
    /**
     * @description 登录
     * @param {Object} context
     * @param {Object} payload username {String} 用户账号
     * @param {Object} payload password {String} 密码
     * @param {Object} payload route {Object} 登录成功后定向的路由对象 任何 vue-router 支持的格式
     */
    async login ({ dispatch }, {
      username = '',
      password = '',
      code = ''
    } = {}) {
      const res = await login({ username, password, code })
      console.log(res)
      // util.cookies.set('uuid', res.uuid)
      // util.cookies.set('token', res.token)
      // // 设置 vuex 用户信息
      // await dispatch('store/user/set', { name: res.name }, { root: true })
      // // 用户登录后从持久化数据加载一系列的设置
      // await dispatch('load')
    },
    /**
     * @description 注销用户并返回登录页面
     * @param {Object} context
     * @param {Object} payload confirm {Boolean} 是否需要确认
     */
    logout ({ commit, dispatch }, { confirm = false } = {}) {
      /**
       * @description 注销
       */
      async function logout () {
        // 删除cookie
        util.cookies.remove('token')
        util.cookies.remove('uuid')
        // 清空 vuex 用户信息
        await dispatch('store/user/set', {}, { root: true })
        // 跳转路由
        router.push({ name: 'login' })
      }
      // 判断是否需要确认
      if (confirm) {
        commit('store/gray/set', true, { root: true })
        MessageBox.confirm('确定要注销当前用户吗', '注销用户', { type: 'warning' })
          .then(() => {
            commit('store/gray/set', false, { root: true })
            logout()
          })
          .catch(() => {
            commit('store/gray/set', false, { root: true })
            Message({ message: '取消注销操作' })
          })
      } else {
        logout()
      }
    },
    /**
     * @description 用户登录后从持久化数据加载一系列的设置
     * @param {Object} context
     */
    async load ({ dispatch }) {
      // 加载用户名
      await dispatch('store/user/load', null, { root: true })
      // 加载主题
      await dispatch('store/theme/load', null, { root: true })
      // 加载页面过渡效果设置
      await dispatch('store/transition/load', null, { root: true })
      // 持久化数据加载上次退出时的多页列表
      await dispatch('store/page/openedLoad', null, { root: true })
      // 持久化数据加载侧边栏配置
      await dispatch('store/menu/asideLoad', null, { root: true })
      // 持久化数据加载全局尺寸
      await dispatch('store/size/load', null, { root: true })
      // 持久化数据加载颜色设置
      await dispatch('store/color/load', null, { root: true })
    }
  }
}
