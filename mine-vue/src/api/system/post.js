import { request } from '@/api/_service.js'

/**
 * 获取岗位分页列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'system/post/index',
    method: 'get',
    params
  })
}

/**
 * 获取岗位列表
 * @returns
 */
export function getPostList (params = {}) {
  return request({
    url: 'system/post/list',
    method: 'get',
    params
  })
}

/**
 * 从回收站获取岗位
 * @returns
 */
export function getPageListByRecycle (params = {}) {
  return request({
    url: 'system/post/recycle',
    method: 'get',
    params
  })
}

/**
 * 获取岗位选择树
 * @returns
 */
export function getSelectTree () {
  return request({
    url: 'system/post/selectTree',
    method: 'get'
  })
}

/**
 * 添加岗位
 * @returns
 */
export function save (params = {}) {
  return request({
    url: 'system/post/save',
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
    url: 'system/post/delete/' + ids,
    method: 'delete'
  })
}

/**
 * 恢复数据
 * @returns
 */
export function recoverys (ids) {
  return request({
    url: 'system/post/recovery/' + ids,
    method: 'put'
  })
}

/**
 * 真实删除
 * @returns
 */
export function realDeletes (ids) {
  return request({
    url: 'system/post/realDelete/' + ids,
    method: 'delete'
  })
}

/**
 * 更新数据
 * @returns
 */
export function update (id, params = {}) {
  return request({
    url: 'system/post/update/' + id,
    method: 'put',
    data: params
  })
}
