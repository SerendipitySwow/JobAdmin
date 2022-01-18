import { request } from '@/utils/request.js'

/**
 * 任务列表 API JS
 */

export default {

  /**
   * 获取任务列表分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'task/mission/index',
      method: 'get',
      params
    })
  },

  /**
    * 获取任务列表选择树 (树表才生效)
    * @returns
    */
  tree () {
    return request({
      url: 'task/mission/tree',
      method: 'get'
    })
  },

  /**
   * 从回收站获取任务列表数据列表
   * @returns
   */
  getRecycleList (params = {}) {
    return request({
      url: 'task/mission/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 添加任务列表
   * @returns
   */
  save (params = {}) {
    return request({
      url: 'task/mission/save',
      method: 'post',
      data: params
    })
  },

  /**
   * 读取任务列表
   * @returns
   */
  read (params = {}) {
    return request({
      url: 'task/mission/read',
      method: 'post',
      data: params
    })
  },

  /**
   * 将任务列表移到回收站
   * @returns
   */
  deletes (ids) {
    return request({
      url: 'task/mission/delete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 恢复任务列表数据
   * @returns
   */
  recoverys (ids) {
    return request({
      url: 'task/mission/recovery/' + ids,
      method: 'put'
    })
  },

  /**
   * 真实删除任务列表
   * @returns
   */
  realDeletes (ids) {
    return request({
      url: 'task/mission/realDelete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 更新任务列表数据
   * @returns
   */
  update (id, params = {}) {
    return request({
      url: 'task/mission/update/' + id,
      method: 'put',
      data: params
    })
  }

}