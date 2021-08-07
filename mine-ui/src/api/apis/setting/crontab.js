import { request } from '@/utils/request.js'

export default {
  /**
   * 获取分页列表
   * @returns
   */
  getPageList (params = {}) {
    return request({
      url: 'setting/crontab/index',
      method: 'get',
      params
    })
  },

  /**
   * 从回收站获取
   * @returns
   */
  getRecyclePageList (params = {}) {
    return request({
      url: 'setting/crontab/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 添加
   * @returns
   */
  save (params = {}) {
    return request({
      url: 'setting/crontab/save',
      method: 'post',
      data: params
    })
  },

  /**
   * 移到回收站
   * @returns
   */
  deletes (ids) {
    return request({
      url: 'setting/crontab/delete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 恢复数据
   * @returns
   */
  recoverys (ids) {
    return request({
      url: 'setting/crontab/recovery/' + ids,
      method: 'put'
    })
  },

  /**
   * 真实删除
   * @returns
   */
  realDeletes (ids) {
    return request({
      url: 'setting/crontab/realDelete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 更新数据
   * @returns
   */
  update (id, params = {}) {
    return request({
      url: 'setting/crontab/update/' + id,
      method: 'put',
      data: params
    })
  }

}