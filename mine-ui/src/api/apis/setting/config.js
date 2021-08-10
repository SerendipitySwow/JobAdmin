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

  /**
   * 清除缓存
   * @returns
   */
   clearCache (params = {}) {
    return request({
      url: 'setting/config/clearCache',
      method: 'post',
      data: params
    })
  },

  /**
   * 保存系统组配置
   * @returns
   */
   saveSystemConfig (params = {}) {
    return request({
      url: 'setting/config/saveSystemConfig',
      method: 'post',
      data: params
    })
  },
}