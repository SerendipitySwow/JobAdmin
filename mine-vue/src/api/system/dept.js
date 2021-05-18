import { request } from '@/api/_service.js'

/**
 * 获取部门树
 * @returns
 */
export function getMenuTree (params = {}) {
  return request({
    url: 'system/dept/index',
    method: 'get',
    params
  })
}

/**
 * 从回收站获取部门树
 * @returns
 */
export function getRecycle (params = {}) {
  return request({
    url: 'system/dept/recycleTree',
    method: 'get',
    params
  })
}

/**
 * 获取部门选择树
 * @returns
 */
export function getSelectTree () {
  return request({
    url: 'system/dept/selectTree',
    method: 'get'
  })
}

/**
 * 添加部门
 * @returns
 */
export function save (params = {}) {
  return request({
    url: 'system/dept/save',
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
    url: 'system/dept/delete/' + ids,
    method: 'delete'
  })
}

/**
 * 恢复数据
 * @returns
 */
export function recoverys (ids) {
  return request({
    url: 'system/dept/recovery/' + ids,
    method: 'put'
  })
}

/**
 * 真实删除
 * @returns
 */
export function realDeletes (ids) {
  return request({
    url: 'system/dept/realDelete/' + ids,
    method: 'delete'
  })
}

/**
 * 更新数据
 * @returns
 */
export function update (id, params = {}) {
  return request({
    url: 'system/dept/update/' + id,
    method: 'put',
    data: params
  })
}
