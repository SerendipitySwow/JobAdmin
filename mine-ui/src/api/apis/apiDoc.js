import { request } from '@/utils/request.js'

/**
 * 接口文档
 */

export default {
  /**
   * 登录接口文档
   * @returns
   */
  login (params = {}) {
    return request({
      url: 'apiDoc/login',
      method: 'post',
      data: params
    })
  },

}