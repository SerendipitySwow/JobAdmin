import { request } from '@/api/_service.js'

/**
 * 获取本地模块分页列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'setting/module/index',
    method: 'get',
    params
  })
}

/**
 * 创建新模块
 * @returns
 */
 export function save (params = {}) {
  return request({
    url: 'setting/module/save',
    method: 'put',
    params
  })
}

/**
 * 删除模块
 * @returns
 */
 export function remove (name) {
  return request({
    url: 'setting/module/delete/' + name,
    method: 'delete'
  })
}

