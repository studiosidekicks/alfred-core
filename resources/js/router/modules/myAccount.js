import Layout from '@/layout';

const myAccountRoutes = [
  {
    path: '/my-account',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/my-account',
        component: () => import('@/views/my-account/index'),
        name: 'my-account',
        meta: { 
          title: 'My Account'
        },
      }
    ],
  }
];

export default myAccountRoutes;