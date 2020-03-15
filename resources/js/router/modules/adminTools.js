import Layout from '@/layout';

const adminToolsRoutes = [
  {
    path: '/admin-tools',
    component: Layout,
    meta: {
      permissions: ['admin-tools.index'],
    },
    children: [
      {
        path: '/admin-tools',
        component: () => import('@/views/admin-tools/index'),
        name: 'admin-tools.index',
        meta: {
          title: 'Admin Tools', 
          icon: 'developer_board', 
          permissions: ['admin-tools.index'],
        },
        children: [
          {
            path: '/admin-tools/groups',
            component: () => import('@/views/admin-tools/groups/List'),
            name: 'groups',
            meta: { 
              title: 'CMS User Groups', 
              icon: 'group',
              permissions: ['admin-tools.groups'],
            }
          },
          {
            path: '/admin-tools/cms-users',
            component: () => import('@/views/admin-tools/cms-users/List'),
            name: 'cms-users',
            meta: { 
              title: 'CMS Users', 
              icon: 'account_circle',
              permissions: ['admin-tools.cms-users'],
            }
          },
          {
            path: '/admin-tools/cms-signins',
            component: () => import('@/views/admin-tools/cms-signins/List'),
            name: 'cms-signins',
            meta: { 
              title: 'CMS Sign-ins', 
              icon: 'how_to_reg',
              permissions: ['admin-tools.cms-signins'],
            }
          },
          {
            path: '/admin-tools/cms-operations',
            component: () => import('@/views/admin-tools/cms-operations/List'),
            name: 'cms-operations',
            meta: { 
              title: 'CMS Operations', 
              icon: 'history',
              permissions: ['admin-tools.cms-operations'],
            }
          },
          {
            path: '/admin-tools/error-logs',
            component: () => import('@/views/admin-tools/error-logs/List'),
            name: 'error-logs',
            meta: { 
              title: 'Error Logs', 
              icon: 'error_outline',
              permissions: ['admin-tools.error-logs'],
            }
          }
        ]
      }
    ],
  }
];

export default adminToolsRoutes;
