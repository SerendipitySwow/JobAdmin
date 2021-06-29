import { request } from '@/api/_service.js'

/**
 * 获取文件分页列表
 * @returns
 */
export function getPageList (params = {}) {
  return request({
    url: 'system/uploadfile/index',
    method: 'get',
    params
  })
}

/**
 * 从回收站获取文件
 * @returns
 */
export function getPageListByRecycle (params = {}) {
  return request({
    url: 'system/uploadfile/recycle',
    method: 'get',
    params
  })
}

/**
 * 移到回收站
 * @returns
 */
export function deletes (ids) {
  return request({
    url: 'system/uploadfile/delete/' + ids,
    method: 'delete'
  })
}

/**
 * 恢复数据
 * @returns
 */
export function recoverys (ids) {
  return request({
    url: 'system/uploadfile/recovery/' + ids,
    method: 'put'
  })
}

/**
 * 真实删除
 * @returns
 */
export function realDeletes (ids) {
  return request({
    url: 'system/uploadfile/realDelete/' + ids,
    method: 'delete'
  })
}
