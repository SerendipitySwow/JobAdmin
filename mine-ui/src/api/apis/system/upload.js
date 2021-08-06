import { request } from '@/utils/request.js'

export default {

  /**
   * 获取文件分页列表
   * @returns
   */
  uploadImage (data = {}) {
    return request({
      url: 'system/uploadImage',
      method: 'post',
      data
    })
  },

}