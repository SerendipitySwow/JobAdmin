import { request } from '@/utils/request.js'

export default {

    /**
     * 获取接收消息列表
     * @returns
     */
    getReceiveList (params = {}) {
        return request({
            url: 'system/queueMessage/receiveList',
            method: 'get',
            params
        })
    },
  
    /**
     * 获取发送消息列表
     * @returns
     */
    getSendList (params = {}) {
        return request({
            url: 'system/queueMessage/sendList',
            method: 'get',
            params
        })
    }
}