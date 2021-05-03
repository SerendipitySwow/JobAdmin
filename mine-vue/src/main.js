import Vue from 'vue'
import i18n from './i18n'
import App from './App'
import mineadmin from '@/plugin/mineadmin'
import './permission'

import router from './router'
import store from '@/store/index'

// 核心插件
Vue.use(mineadmin)

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
    // 确认已经加载多标签页数据 https://github.com/d2-projects/d2-admin/issues/201
    this.$store.dispatch('store/page/isLoaded')
    // 确认已经加载组件尺寸设置 https://github.com/d2-projects/d2-admin/issues/198
    this.$store.dispatch('store/size/isLoaded')
  },
  watch: {
    // 检测路由变化切换侧边栏内容
    '$route.matched': {
      handler (matched) {
        if (matched.length > 0) {
          const _side = this.$store.state.store.menu.header.filter(menu => menu.path === matched[0].path)
          if (matched[0].name === 'dashboard') {
            this.$store.commit('store/menu/asideSet', this.$store.state.store.permission.quick)
          } else {
            this.$store.commit('store/menu/asideSet', _side.length > 0 ? _side[0].children : [])
          }
        }
      },
      immediate: true
    }
  }
}).$mount('#app')
