import { request } from '@/utils/request.js'

/**
 * 消息管理 API JS
 */

export default {

  /**
   * 获取消息管理分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'system/queueMessage/index',
      method: 'get',
      params
    })
  },
	/**
	 * 获取用户消息列表
	 * @returns
	 */
	getUserList (params = {}) {
		return request({
			url: 'system/queueMessage/userMessage',
			method: 'get',
			params
		})
	},

	/**
	 * 获取消息管理日志列表
	 * @returns
	 */
	getLogList (params = {}) {
		return request({
			url: 'system/queueMessage/log',
			method: 'get',
			params
		})
	},

  /**
   * 从回收站获取消息管理数据列表
   * @returns
   */
  getRecycleList (params = {}) {
    return request({
      url: 'system/queueMessage/recycle',
      method: 'get',
      params
    })
  },

  /**
   * 添加消息管理
   * @returns
   */
  send (params = {}) {
    return request({
      url: 'system/queueMessage/send',
      method: 'post',
      data: params
    })
  },

  /**
   * 读取消息管理
   * @returns
   */
  read (params = {}) {
    return request({
      url: 'system/queueMessage/read',
      method: 'post',
      data: params
    })
  },

  /**
   * 将消息管理移到回收站
   * @returns
   */
  deletes (ids) {
    return request({
      url: 'system/queueMessage/delete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 恢复消息管理数据
   * @returns
   */
  recoverys (ids) {
    return request({
      url: 'system/queueMessage/recovery/' + ids,
      method: 'put'
    })
  },

  /**
   * 真实删除消息管理
   * @returns
   */
  realDeletes (ids) {
    return request({
      url: 'system/queueMessage/realDelete/' + ids,
      method: 'delete'
    })
  },

  /**
   * 更新消息管理数据
   * @returns
   */
  update (id, params = {}) {
    return request({
      url: 'system/queueMessage/update/' + id,
      method: 'put',
      data: params
    })
  }

}
