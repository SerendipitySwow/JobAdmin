import { Notification } from 'element-ui'
import axios from 'axios'
import Adapter from 'axios-mock-adapter'
import { get, isEmpty } from 'lodash'
import qs from 'qs'
import util from '@/libs/util'
import store from '@/store'

/**
 * @description 记录和显示错误
 * @param {Error} error 错误对象
 */
function handleError (error) {
  // 显示提示
  Notification.error({
    message: error == undefined ? '服务器错误' : error.message,
    title: '错误',
    duration: 5 * 1000
  })
  // 检查是否需要跳转登录页
  const status = get(error, 'response.status')
  if (status === 401) {
    store.dispatch('store/user/cancellation', { root: true })
  }
}

/**
 * @description 创建请求实例
 */
function createService () {
  // 创建一个 axios 实例
  const service = axios.create()
  // 请求拦截
  service.interceptors.request.use(
    config => config,
    error => {
      // 发送失败
      return Promise.reject(error)
    }
  )
  // 响应拦截
  service.interceptors.response.use(
    response => {
      // 有 code 判断为项目接口请求
      if (response.status === 200 && (!response.data.success || response.data.code !== 200)) {
        Notification.error(
          { message: response.data.message, title: '提示', duration: 5 * 1000 }
        )
        return null;
      } else if (response.status === 200) {
        return response.data
      } else {
        switch (response.status) {
          case 401: throw new Error(response.data.message)
          case 403: throw new Error(response.data.message)
          // 根据需要添加其它判断
          default: throw new Error(`${response.data.message}: ${response.config.url}`)
        }
      }
    },
    error => {
      const status = get(error, 'response.status')
      switch (status) {
        case 400: error.message = '请求错误'; break
        case 401: error.message = `${error.response.data.message}`; break
        case 403: error.message = `${error.response.data.message}`; break
        case 404: error.message = `请求地址出错: ${error.response.config.url}`; break
        case 408: error.message = '请求超时'; break
        case 500: error.message = `服务器错误`; break
        case 501: error.message = '服务未实现'; break
        case 502: error.message = '网关错误'; break
        case 503: error.message = '服务不可用'; break
        case 504: error.message = '网关超时'; break
        case 505: error.message = 'HTTP版本不受支持'; break
        default: break
      }
      handleError(error)
      throw error
    }
  )
  return service
}

function stringify (data) {
  return qs.stringify(data, { allowDots: true, encode: false })
}

/**
 * @description 创建请求方法
 * @param {Object} service axios 实例
 */
function createRequest (service) {
  return function (config) {
    const token = util.cookies.get('token')
    const configDefault = {
      headers: {
        Authorization: `bearer ${token}`,
        'Content-Type': get(config, 'headers.Content-Type', 'application/json;charset=UTF-8')
      },
      timeout: 10000,
      baseURL: process.env.VUE_APP_API,
      data: {}
    }
    const option = Object.assign(configDefault, config)
    // json
    if (!isEmpty(option.params)) {
      option.url = option.url + '?' + stringify(option.params)
      option.params = {}
    }
    // form
    if (!isEmpty(option.data) && option.headers['Content-Type'] === 'application/x-www-form-urlencoded;charset=UTF-8') {
      option.data = stringify(option.data)
    }
    return service(option)
  }
}

// 用于真实网络请求的实例和请求方法
export const service = createService()
export const request = createRequest(service)

// 用于模拟网络请求的实例和请求方法
export const serviceForMock = createService()
export const requestForMock = createRequest(serviceForMock)

// 网络请求数据模拟工具
export const mock = new Adapter(serviceForMock)
