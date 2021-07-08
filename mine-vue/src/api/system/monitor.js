import { request } from '@/api/_service.js'

/**
 * 获取服务器信息
 * @returns
 */
export function getServerInfo () {
  return request({
    url: 'system/monitor/serviceMonitor',
    method: 'get'
  })
}
