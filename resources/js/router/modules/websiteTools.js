import Layout from '@/layout';

const websiteToolsRoutes = [
  {
    path: '/website-tools',
    component: Layout,
    meta: {
      permissions: ['website-tools.index'],
    },
    children: [
      {
        path: '/website-tools',
        component: () => import('@/views/website-tools/index'),
        name: 'website-tools.index',
        meta: {
          title: 'Website Tools', 
          icon: 'perm_data_setting', 
          permissions: ['website-tools.index'],
        },
        children: [
          {
            path: '/website-tools/scripts',
            component: () => import('@/views/website-tools/scripts/index'),
            name: 'scripts',
            meta: { 
              title: 'Website Scripts', 
              icon: 'code',
              permissions: ['website-tools.scripts'],
            }
          },
          {
            path: '/website-tools/website-users',
            component: () => import('@/views/website-tools/website-users/List'),
            name: 'website-users',
            meta: { 
              title: 'Website Users', 
              icon: 'account_circle',
              permissions: ['website-tools.website-users'],
            }
          },
          {
            path: '/website-tools/languages',
            component: () => import('@/views/website-tools/languages/List'),
            name: 'languages',
            meta: { 
              title: 'Languages', 
              icon: 'language',
              permissions: ['website-tools.languages'],
            }
          }
        ]
      }
    ],
  }
];

export default websiteToolsRoutes;
