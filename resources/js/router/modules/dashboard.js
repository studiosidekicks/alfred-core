import Layout from '@/layout';

const dashboardRoutes = [
  {
    path: '/dashboard',
    component: Layout,
    meta: {
      permissions: ['dashboard.index'],
    },
    children: [
      {
        path: '/dashboard',
        component: () => import('@/views/dashboard/index'),
        name: 'dashboard',
        meta: { 
          title: 'Dashboard', 
          icon: 'dashboard'
        },
      }
    ],
  }
];

export default dashboardRoutes;