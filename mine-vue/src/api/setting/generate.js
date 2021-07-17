import { request } from '@/api/_service.js'

/**
 * 获取代码生成列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'setting/code/index',
    method: 'get',
    params
  })
}

/**
 * 删除
 * @returns
 */
 export function deletes (params) {
  return request({
    url: 'setting/code/delete/' + params,
    method: 'delete'
  })
}

/**
 * 装载数据表
 * @returns
 */
export function loadTable (data = {}) {
  return request({
    url: 'setting/code/loadTable',
    method: 'post',
    data
  })
}

/**
 * 同步数据表
 * @returns
 */
export function sync (data) {
  return request({
    url: 'setting/code/sync/' + data,
    method: 'put'
  })
}

// 获取表中字段信息
export function getTableColumns(params = {}) {
  return request({
    url: 'setting/code/getTableColumns',
    method: 'get',
    params
  })
}