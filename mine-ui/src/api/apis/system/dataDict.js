import { request } from '@/utils/request.js'

export default {
    /**
     * 快捷查询字典
     * @param {*} params
     * @returns
     */
    getDicts(code) {
        return request({
            url: 'system/dictData/list?code=' + code,
            method: 'get'
        })
    },

    /**
     * 获取字典数据分页列表
     * @returns
     */
    getPageList(params = {}) {
        return request({
            url: 'system/dictData/index',
            method: 'get',
            params
        })
    },

    /**
     * 从回收站获取字典数据
     * @returns
     */
    getRecyclePageList(params = {}) {
        return request({
            url: 'system/dictData/recycle',
            method: 'get',
            params
        })
    },

    /**
     * 添加字典数据
     * @returns
     */
    saveDictData(params = {}) {
        return request({
            url: 'system/dictData/save',
            method: 'post',
            data: params
        })
    },

    /**
     * 移到回收站
     * @returns
     */
    deletesDictData(ids) {
        return request({
            url: 'system/dictData/delete/' + ids,
            method: 'delete'
        })
    },

    /**
     * 恢复数据
     * @returns
     */
    recoverysDictData(ids) {
        return request({
            url: 'system/dictData/recovery/' + ids,
            method: 'put'
        })
    },

    /**
     * 真实删除
     * @returns
     */
    realDeletesDictData(ids) {
        return request({
            url: 'system/dictData/realDelete/' + ids,
            method: 'delete'
        })
    },

    /**
     * 更新数据
     * @returns
     */
    updateDictData(id, params = {}) {
        return request({
            url: 'system/dictData/update/' + id,
            method: 'put',
            data: params
        })
    }
}