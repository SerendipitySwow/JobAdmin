import { request } from '@/api/_service.js'

/**
 * 获取角色分页列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'system/role/index',
    method: 'get',
    params
  })
}

/**
 * 获取角色列表
 * @returns
 */
export function getRoleList (params = {}) {
  return request({
    url: 'system/role/list',
    method: 'get',
    params
  })
}

/**
 * 从回收站获取角色
 * @returns
 */
export function getPageListByRecycle (params = {}) {
  return request({
    url: 'system/role/recycle',
    method: 'get',
    params
  })
}

/**
 * 获取角色选择树
 * @returns
 */
export function getSelectTree () {
  return request({
    url: 'system/role/selectTree',
    method: 'get'
  })
}

/**
 * 添加角色
 * @returns
 */
export function save (params = {}) {
  return request({
    url: 'system/role/save',
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
    url: 'system/role/delete/' + ids,
    method: 'delete'
  })
}

/**
 * 恢复数据
 * @returns
 */
export function recoverys (ids) {
  return request({
    url: 'system/role/recovery/' + ids,
    method: 'put'
  })
}

/**
 * 真实删除
 * @returns
 */
export function realDeletes (ids) {
  return request({
    url: 'system/role/realDelete/' + ids,
    method: 'delete'
  })
}

/**
 * 更新数据
 * @returns
 */
export function update (id, params = {}) {
  return request({
    url: 'system/role/update/' + id,
    method: 'put',
    data: params
  })
}

/**
 * 更改角色状态
 * @returns
 */
export function changeRoleStatus (params = {}) {
  return request({
    url: 'system/role/changeRoleStatus',
    method: 'put',
    data: params
  })
}
