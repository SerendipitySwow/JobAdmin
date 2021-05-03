import { Message, MessageBox } from 'element-ui'
import util from '@/libs/util.js'
import router from '@/router'
import { Login, Logout, getInfo } from '@/api/system/login.js'

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
    async login ({ commit }, { username = '', password = '', code = '' } = {}) {
      await Login({ username, password, code }).then(res => {
        util.cookies.set('token', res.data.token)
      })
    },
    async userinfo ({ commit, dispatch }) {
      return new Promise((resolve, reject) => {
        getInfo().then(response => {
          if (response.data.roles && response.data.routers.length > 0) {
            util.cookies.set('uuid', response.data.id)
            // 设置 vuex 用户信息
            dispatch('store/user/set', { name: response.data.user.username }, { root: true })
            // 用户登录后从持久化数据加载一系列的设置
            dispatch('load')
            commit('store/permission/setUserInfo', response.data.user, { root: true })
            commit('store/permission/setRoles', response.data.roles, { root: true })
            commit('store/permission/setRouters', response.data.routers, { root: true })
            commit('store/permission/setQuick', response.data.quickMenu, { root: true })
            resolve()
          }
        }).catch(error => {
          reject(error)
        })
      })
    },
    /**
     * @description 注销用户并返回登录页面
     * @param {Object} context
     * @param {Object} payload confirm {Boolean} 是否需要确认
     */
    async logout ({ commit, dispatch }, { confirm = false } = {}) {
      async function goodBye () {
        await Logout()
        util.cookies.remove('token')
        util.cookies.remove('uuid')
        // 清空 vuex 用户信息
        await dispatch('store/user/set', {}, { root: true })
        // 清空动态路由信息
        commit('store/permission/setRoles', [], { root: true })
        commit('store/permission/setPermissions', [], { root: true })
        commit('store/permission/setRouters', [], { root: true })
        commit('store/permission/setQuick', [], { root: true })
        // 跳转路由
        router.push({ name: 'login' })
      }
      // 判断是否需要确认
      if (confirm) {
        commit('store/gray/set', true, { root: true })
        MessageBox.confirm('确定要注销当前用户吗', '注销用户', { type: 'warning' })
          .then(() => {
            commit('store/gray/set', false, { root: true })
            goodBye()
          })
          .catch(() => {
            commit('store/gray/set', false, { root: true })
            Message({ message: '取消注销操作' })
          })
      } else {
        goodBye()
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
