import request from '@/utils/request';

export function getGroupsList() {
  return request({
    url: '/groups',
    method: 'get',
  });
}