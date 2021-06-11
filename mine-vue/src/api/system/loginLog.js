import { request } from '@/api/_service.js'

/**
 * 获取登录日志分页列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'system/logs/getLoginLogPageList',
    method: 'get',
    params
  })
}

/**
 * 真实删除
 * @returns
 */
export function realDeletes (ids) {
  return request({
    url: 'system/logs/realDeleteLoginLog/' + ids,
    method: 'delete'
  })
}
