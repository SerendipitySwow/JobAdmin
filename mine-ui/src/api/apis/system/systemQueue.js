import { request } from '@/utils/request.js'

/**
 * 队列监控 API JS
 */

export default {

  /**
   * 获取队列监控分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'system/queue/index',
      method: 'get',
      params
    })
  },

  /**
   * 从回收站获取队列监控数据列表
   * @returns
   */
  getRecycleList (params = {}) {
    return request({
      url: 'system/queue/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 添加队列监控
   * @returns
   */
  save (params = {}) {
    return request({
      url: 'system/queue/save',
      method: 'post',
      data: params
    })
  },

  /**
   * 读取队列监控
   * @returns
   */
  read (params = {}) {
    return request({
      url: 'system/queue/read',
      method: 'post',
      data: params
    })
  },

  /**
   * 将队列监控移到回收站
   * @returns
   */
  deletes (ids) {
    return request({
      url: 'system/queue/delete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 恢复队列监控数据
   * @returns
   */
  recoverys (ids) {
    return request({
      url: 'system/queue/recovery/' + ids,
      method: 'put'
    })
  },

  /**
   * 真实删除队列监控
   * @returns
   */
  realDeletes (ids) {
    return request({
      url: 'system/queue/realDelete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 更新队列监控数据
   * @returns
   */
  update (id, params = {}) {
    return request({
      url: 'system/queue/update/' + id,
      method: 'put',
      data: params
    })
  }

}
