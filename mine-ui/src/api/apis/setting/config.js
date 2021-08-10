import { request } from '@/utils/request.js'

export default {
  /**
   * 获取系统组配置
   * @returns
   */
  getSystemConfig () {
    return request({
      url: 'setting/config/getSystemConfig',
      method: 'get',
    })
  },

  /**
   * 获取扩展组配置
   * @returns
   */
  getExtendConfig () {
    return request({
      url: 'setting/config/getExtendConfig',
      method: 'get',
    })
  },
}