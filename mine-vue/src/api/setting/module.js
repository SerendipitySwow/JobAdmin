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

