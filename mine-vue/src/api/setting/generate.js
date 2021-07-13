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