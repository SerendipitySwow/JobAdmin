import { request } from '@/api/_service.js'

/**
 * 获取菜单树
 * @returns
 */
export function getMenuTree (params = {}) {
  return request({
    url: 'system/menu/index',
    method: 'get',
    data: params
  })
}

/**
 * 从回收站获取菜单树
 * @returns
 */
export function getRecycle (params = {}) {
  return request({
    url: 'system/menu/getRecycle',
    method: 'get',
    data: params
  })
}

/**
 * 添加菜单
 * @returns
 */
export function save (params = {}) {
  return request({
    url: 'system/menu/save',
    method: 'post'
  })
}

/**
 * 移到回收站
 * @returns
 */
export function deletes (ids) {
  return request({
    url: 'system/menu/delete/' + ids,
    method: 'delete'
  })
}

/**
 * 更新数据
 * @returns
 */
export function update (id) {
  return request({
    url: 'system/menu/update/' + id,
    method: 'put'
  })
}
