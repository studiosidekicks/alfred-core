import request from '@/utils/request';

export function getInfo() {
  return request({
    url: '/my-account',
    method: 'get',
  });
}