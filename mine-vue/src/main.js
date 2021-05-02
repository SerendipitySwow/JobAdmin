import Vue from 'vue'
import i18n from './i18n'
import App from './App'
import d2Admin from '@/plugin/d2admin'
import store from '@/store/index'
import router from './router'
import './permission'

// 核心插件
Vue.use(d2Admin)

// const menuAside = store.state.store.menu
// console.log(menuAside)

new Vue({
  store,
  i18n,
  router,
  render: h => h(App),
  created () {
    // 处理路由 得到每一级的路由设置
    // this.$store.commit('store/page/init', router)
  },
  mounted () {
    // 展示系统信息
    this.$store.commit('store/releases/versionShow')
    // 用户登录后从数据库加载一系列的设置
    this.$store.dispatch('store/account/load')
    // 获取并记录用户 UA
    this.$store.commit('store/ua/get')
    // 初始化全屏监听
    this.$store.dispatch('store/fullscreen/listen')
  },
  watch: {
    // 检测路由变化切换侧边栏内容
    '$route.matched': {
      handler (matched) {
        if (matched.length > 0) {
          const _side = this.$store.state.store.menu.header.filter(menu => menu.path === matched[0].path)
          this.$store.commit('store/menu/asideSet', _side.length > 0 ? _side[0].children : [])
        }
      },
      immediate: true
    }
  }
}).$mount('#app')
