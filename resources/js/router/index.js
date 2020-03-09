import Vue from 'vue';
import Router from 'vue-router';

/**
 * Layzloading will create many files and slow on compiling, so best not to use lazyloading on devlopment.
 * The syntax is lazyloading, but we convert to proper require() with babel-plugin-syntax-dynamic-import
 * @see https://doc.laravue.dev/guide/advanced/lazy-loading.html
 */

Vue.use(Router);

/* Layouts */
import AuthLayout from '@/auth/layout';
import Layout from '@/layout';

/* Router for modules */
import componentRoutes from './modules/components';
import adminRoutes from './modules/admin';
import nestedRoutes from './modules/nested';
import permissionRoutes from './modules/permission';

/**
 * Sub-menu only appear when children.length>=1
 * @see https://doc.laravue.dev/guide/essentials/router-and-nav.html
 **/

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    roles: ['admin', 'editor']   Visible for these roles only
    permissions: ['view menu zip', 'manage user'] Visible for these permissions only
    title: 'title'               the name show in sub-menu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if true, the page will no be cached(default is false)
    breadcrumb: false            if false, the item will hidden in breadcrumb (default is true)
    affix: true                  if true, the tag will affix in the tags-view
  }
**/

export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index'),
      },
    ],
  },
  {
    path: '/auth/login',
    component: AuthLayout,
    hidden: true,
    children: [
      {
        path: '',
        component: () => import('@/auth/components/login'),
        name: 'auth.login',
        meta: { title: 'Log in', noCache: true },
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
        meta: { title: 'Log out', noCache: true },
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
        meta: { title: 'Forgot password?', noCache: true },
      }
    ],
  },
  {
    path: '',
    component: Layout,
    redirect: 'dashboard',
    hidden: true
  },
  {
    path: '/dashboard',
    component: Layout,
    children: [
      {
        path: '',
        component: () => import('@/views/dashboard/index'),
        name: 'Dashboard',
        meta: { 
          title: 'Dashboard', 
          icon: 'mdi-view-dashboard'
        },
      }
    ],
  },
  {
    path: '/my-account',
    component: Layout,
    children: [
      {
        path: '',
        component: () => import('@/views/my-account/index'),
        name: 'MyAccount',
        meta: { 
          title: 'My Account', 
          icon: 'mdi-antenna'
        },
      }
    ],
  },
];

export const asyncRoutes = [
  
];

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  base: process.env.MIX_LARAVUE_PATH,
  routes: constantRoutes,
});

const router = createRouter();

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher; // reset router
}

export default router;
