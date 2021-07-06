import Vue from 'vue'
import i18n from './i18n'
import App from './App'
import mineadmin from '@/plugin/mineadmin'
import router from './router'
import store from '@/store/index'
import permission from '@/directive/permission/index'
import { getDicts } from './api/system/dictData'
import TableRightToolbar from '@/components/ma-table-right-toolbar'
import Upload from '@/components/ma-upload'
import './permission'
import '@/assets/style/mine-admin.css'

Vue.use(mineadmin)
Vue.use(permission)

Vue.prototype.getDicts = getDicts

// 全局挂载组件
Vue.component('TableRightToolbar', TableRightToolbar)
Vue.component('Upload', Upload)

// 全局挂载方法
Vue.prototype.success = function (msg) {
  this.$message({ showClose: true, message: msg, type: 'success' })
}

Vue.prototype.error = function (msg) {
  this.$message({ showClose: true, message: msg, type: 'error' })
}

new Vue({
  store,
  i18n,
  router,
  render: h => h(App),
  mounted () {
    // 展示系统信息
    this.$store.commit('store/releases/versionShow')
    // 用户登录后从数据库加载一系列的设置
    this.$store.dispatch('store/account/load')
    // 获取并记录用户 UA
    this.$store.commit('store/ua/get')
    // 初始化全屏监听
    this.$store.dispatch('store/fullscreen/listen')
    // 确认已经加载多标签页数据
    this.$store.dispatch('store/page/isLoaded')
    // 确认已经加载组件尺寸设置
    this.$store.dispatch('store/size/isLoaded')
  },
  watch: {
    // 检测路由变化切换侧边栏内容
    '$route.matched': {
      handler (matched) {
        if (matched.length > 0) {
          const _side = this.$store.getters.menus.filter(menu => menu.path === matched[0].path)
          if (matched[0].path === '') {
            this.$store.commit('store/menu/asideSet', this.$store.getters.quick)
          } else {
            this.$store.commit('store/menu/asideSet', _side.length > 0 ? _side[0].children : [])
          }
        }
      },
      immediate: true
    }
  }
}).$mount('#app')
