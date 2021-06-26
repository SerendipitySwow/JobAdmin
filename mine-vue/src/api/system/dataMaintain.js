import { request } from '@/api/_service.js'

/**
 * 获取数据表分页列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'system/dataMaintain/index',
    method: 'get',
    params
  })
}
