import Vue from 'vue'

import maContainer from './ma-container'
import maContainerFrame from './ma-container-frame'
import maLinkBtn from './ma-link-btn'

// 注意 有些组件使用异步加载会有影响
Vue.component('ma-container', maContainer)
Vue.component('ma-container-frame', maContainerFrame)
Vue.component('ma-link-btn', maLinkBtn)
Vue.component('ma-count-up', () => import('./ma-count-up'))
Vue.component('ma-highlight', () => import('./ma-highlight'))
Vue.component('ma-icon', () => import('./ma-icon'))
Vue.component('ma-icon-svg', () => import('./ma-icon-svg/index.vue'))
Vue.component('ma-icon-select', () => import('./ma-icon-select/index.vue'))
Vue.component('ma-icon-svg-select', () => import('./ma-icon-svg-select/index.vue'))
Vue.component('ma-module-index-banner', () => import('./ma-module-index-banner'))
Vue.component('ma-module-index-menu', () => import('./ma-module-index-menu'))
Vue.component('ma-scrollbar', () => import('./ma-scrollbar'))
