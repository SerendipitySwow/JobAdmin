import { request } from '@/api/_service.js'

/**
 * 获取验证码
 * @returns
 */
export function getCaptcha () {
  return request({
    url: 'system/captcha',
    method: 'get'
  })
}

/**
 * 用户登录
 * @param {object} params
 * @returns
 */
export function login (params = {}) {
  return request({
    url: 'system/login',
    method: 'post',
    data: params
  })
}

/**
 * 用户退出
 * @param {object} params
 * @returns
 */
export function logout (params = {}) {
  return request({
    url: 'system/logout',
    method: 'post',
    data: params
  })
}
