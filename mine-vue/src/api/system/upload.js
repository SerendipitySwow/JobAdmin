import { request } from '@/api/_service.js'

/**
 * 获取目录列表
 * @returns
 */
 export function getDirectory (params = {}) {
  return request({
    url: 'system/getDirectory',
    method: 'get',
    params
  })
}

/**
 * 获取目录列表
 * @returns
 */
 export function getAllFiles (params = {}) {
  return request({
    url: 'system/getAllFiles',
    method: 'get',
    params
  })
}

/**
 * 上传图片
 * @returns
 */
 export function uploadImage (data = {}) {
  return request({
    url: 'system/uploadImage',
    method: 'post',
    data
  })
}

/**
 * 上传文件
 * @returns
 */
 export function uploadFile (data = {}) {
  return request({
    url: 'system/uploadFile',
    method: 'post',
    data
  })
}