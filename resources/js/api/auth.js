import request from '@/utils/request';

export function login(data) {
  return request({
    url: '/auth/login',
    method: 'post',
    data: data,
  });
}

export function getInfo() {
  return request({
    url: '/my-account',
    method: 'get',
  });
}

export function logout() {
  return request({
    url: '/auth/logout',
    method: 'post',
  });
}

export function forgotPassword(data) {
  return request({
    url: '/auth/password/reminder',
    method: 'post',
    data: data,
  });
}