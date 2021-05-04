import cookies from './util.cookies'
import db from './util.db'
import log from './util.log'
import { uniqueId } from 'lodash'

const util = {
  cookies,
  db,
  log
}

/**
 * @description 更新标题
 * @param {String} title 标题
 */
util.title = function (titleText) {
  const processTitle = process.env.VUE_APP_TITLE || 'MineAdmin'
  window.document.title = `${titleText ? `${titleText} - ` : ''}${processTitle}`
}

/**
 * @description 打开新页面
 * @param {String} url 地址
 */
util.open = function (url) {
  var a = document.createElement('a')
  a.setAttribute('href', url)
  a.setAttribute('target', '_blank')
  a.setAttribute('id', 'd2admin-link-temp')
  document.body.appendChild(a)
  a.click()
  document.body.removeChild(document.getElementById('d2admin-link-temp'))
}

/**
 * @description 给菜单数据补充上 path 字段
 * @param {Array} menu 原始的菜单数据
 */
util.supplementPath = function (menu) {
  return menu.map(e => {
    return {
      ...e,
      path: e.path || uniqueId('d2-menu-empty-'),
      title: e.meta.title,
      icon: e.meta.icon,
      ...e.children ? {
        children: util.supplementPath(e.children)
      } : {}
    }
  })
}

export default util
