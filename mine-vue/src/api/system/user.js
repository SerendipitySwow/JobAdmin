import { request } from '@/api/_service.js'

/**
 * 获取用户
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'system/user/index',
    method: 'get',
    params
  })
}

/**
 * 从回收站获取用户
 * @returns
 */
export function getPageListByRecycle (params = {}) {
  return request({
    url: 'system/user/recycle',
    method: 'get',
    params
  })
}

/**
 * 添加用户
 * @returns
 */
export function save (params = {}) {
  return request({
    url: 'system/user/save',
    method: 'post',
    data: params
  })
}

/**
 * 移到回收站
 * @returns
 */
export function deletes (ids) {
  return request({
    url: 'system/user/delete/' + ids,
    method: 'delete'
  })
}

/**
 * 恢复数据
 * @returns
 */
export function recoverys (ids) {
  return request({
    url: 'system/user/recovery/' + ids,
    method: 'put'
  })
}

/**
 * 真实删除
 * @returns
 */
export function realDeletes (ids) {
  return request({
    url: 'system/user/realDelete/' + ids,
    method: 'delete'
  })
}

/**
 * 更新数据
 * @returns
 */
export function update (id, params = {}) {
  return request({
    url: 'system/user/update/' + id,
    method: 'put',
    data: params
  })
}