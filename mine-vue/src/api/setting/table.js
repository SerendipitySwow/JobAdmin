import { request } from '@/api/_service.js'

/**
 * 获取表设计的必要系统信息
 * @returns
 */
export function getSystemInfo () {
  return request({
    url: 'setting/table/getSystemInfo',
    method: 'get'
  })
}
