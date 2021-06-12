import { request } from '@/api/_service.js'

/**
 * 获取操作日志分页列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'system/logs/getOperLogPageList',
    method: 'get',
    params
  })
}

/**
 * 删除
 * @returns
 */
export function deletes (ids) {
  return request({
    url: 'system/logs/deleteOperLog/' + ids,
    method: 'delete'
  })
}
