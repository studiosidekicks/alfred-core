import AuthLayout from '@/auth/layout';

const authRoutes = [
  {
    path: '/auth/login',
    component: AuthLayout,
    hidden: true,
    children: [
      {
        path: '',
        component: () => import('@/auth/components/login'),
        name: 'auth.login',
        meta: { 
          title: 'Log in', 
          noCache: true 
        },
        props: true
      }
    ],
  },
  {
    path: '/auth/logout',
    component: AuthLayout,
    hidden: true,
    children: [
      {
        path: '',
        component: () => import('@/auth/components/logout'),
        name: 'auth.logout',
        meta: {
          title: 'Log out', 
          noCache: true
        },
      }
    ],
  },
  {
    path: '/auth/forgot-password',
    component: AuthLayout,
    hidden: true,
    children: [
      {
        path: '',
        component: () => import('@/auth/components/forgotPassword'),
        name: 'auth.forgot-password',
        meta: {
          title: 'Forgot password?', 
          noCache: true
        },
      }
    ],
  }
];

export default authRoutes;