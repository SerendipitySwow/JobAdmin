import { request } from '@/api/_service.js'

/**
 * 获取字典类型分页列表
 * @returns
 */
export function getTypePageList (params = {}) {
  return request({
    url: 'system/dictType/index',
    method: 'get',
    params
  })
}

/**
 * 获取字典类型，无分页
 * @returns
 */
 export function getTypeList (params = {}) {
  return request({
    url: 'system/dictType/list',
    method: 'get',
    params
  })
}

/**
 * 从回收站获取字典类型
 * @returns
 */
export function getTypePageListByRecycle (params = {}) {
  return request({
    url: 'system/dictType/recycle',
    method: 'get',
    params
  })
}

/**
 * 添加字典类型
 * @returns
 */
export function saveDictType (params = {}) {
  return request({
    url: 'system/dictType/save',
    method: 'post',
    data: params
  })
}

/**
 * 移到回收站
 * @returns
 */
export function deletesDictType (ids) {
  return request({
    url: 'system/dictType/delete/' + ids,
    method: 'delete'
  })
}

/**
 * 恢复数据
 * @returns
 */
export function recoverysDictType (ids) {
  return request({
    url: 'system/dictType/recovery/' + ids,
    method: 'put'
  })
}

/**
 * 真实删除
 * @returns
 */
export function realDeletesDictType (ids) {
  return request({
    url: 'system/dictType/realDelete/' + ids,
    method: 'delete'
  })
}

/**
 * 更新数据
 * @returns
 */
export function updateDictType (id, params = {}) {
  return request({
    url: 'system/dictType/update/' + id,
    method: 'put',
    data: params
  })
}
