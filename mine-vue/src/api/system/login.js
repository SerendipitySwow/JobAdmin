import { request } from '@/api/_service.js'

/**
 * 获取验证码
 * @param object params
 * @returns
 */
export function getCaptcha (params = {}) {
  return request({
    url: 'system/captcha',
    method: 'get',
    data: params
  })
}

/**
 * 用户登录
 * @param object params
 * @returns
 */
export function login (params = {}) {
  return request({
    url: 'system/login',
    method: 'post',
    data: params
  })
}
