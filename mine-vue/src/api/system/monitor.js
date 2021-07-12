import { request } from '@/api/_service.js'

/**
 * 获取服务器信息
 * @returns
 */
export function getServerInfo () {
  return request({
    url: 'system/server/monitor',
    method: 'get'
  })
}

/**
 * 获取依赖包列表
 * @returns
 */
 export function getPackagePageList (params = {}) {
  return request({
    url: 'system/rely/index',
    method: 'get',
    params
  })
}

/**
 * 获取依赖包列表
 * @returns
 */
 export function getPackageDetail (name) {
  return request({
    url: 'system/rely/detail?name='+name,
    method: 'get',
  })
}
