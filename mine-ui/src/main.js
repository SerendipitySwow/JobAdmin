import ElementPlus from 'element-plus'
import locale from 'element-plus/lib/locale/lang/zh-cn'
import 'element-plus/lib/theme-chalk/index.css'
import 'element-plus/lib/theme-chalk/display.css'
import { createApp } from 'vue'
import App from './App.vue'
import config from "./config"
import router from './router'
import store from './store'
import api from './api'
import tool from './utils/tool'
import hasPermission from './utils/permission'
import hasRole from './utils/role'
import errorHandler from './utils/errorHandler'
import maTable from './components/maTable'          // 原scTable，进行了系统适配优化，与原版scTable并存
import scTable from './components/scTable'
import scFilterBar from './components/scFilterBar'
import scUpload from './components/scUpload'
import scUploadMultiple from './components/scUpload/multiple'
import scFormTable from './components/scFormTable'
import scTableSelect from './components/scTableSelect'
import scPageHeader from './components/scPageHeader'
import auth from './directives/auth'
import role from './directives/role'

const app = createApp(App)

//挂载全局对象
app.config.globalProperties.$CONFIG = config
app.config.globalProperties.$TOOL = tool
app.config.globalProperties.$API = api
app.config.globalProperties.$AUTH = hasPermission
app.config.globalProperties.$ROLE = hasRole

app.use(store)
app.use(router)
app.use(ElementPlus, {size: 'small', locale: locale})

//注册全局组件
app.component('maTable', maTable)
app.component('scTable', scTable)
app.component('scFilterBar', scFilterBar)
app.component('scUpload', scUpload)
app.component('scUploadMultiple', scUploadMultiple)
app.component('scFormTable', scFormTable)
app.component('scTableSelect', scTableSelect)
app.component('scPageHeader', scPageHeader)

//注册全局指令
app.directive('auth', auth)
app.directive('role', role)

//全局代码错误捕捉
app.config.errorHandler = errorHandler

tool.capsule('MineAdmin', `v${config.APP_VER}`)
console.log('MineAdmin 官网  https://www.mineadmin.com')
console.log('MineAdmin 文档  https://doc.mineadmin.com')
console.log('MineAdmin Gitee https://gitee.com/xmo/MineAdmin')
console.log('请不要吝啬您的 star，谢谢 ~')

//挂载app
app.mount('#app')
