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

/**
 * 获取表字段列表
 * @returns
 */
 export function getColumnList (table) {
  return request({
    url: 'system/dataMaintain/columnList?table=' + table,
    method: 'get'
  })
}

/**
 * 优化表
 * @returns
 */
 export function optimize (data = {}) {
  return request({
    url: 'system/dataMaintain/optimize',
    method: 'post',
    data
  })
}

/**
 * 清理表碎片
 * @returns
 */
 export function fragment (data = {}) {
  return request({
    url: 'system/dataMaintain/fragment',
    method: 'post',
    data
  })
}
