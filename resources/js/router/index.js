import Vue from 'vue';
import Router from 'vue-router';

/**
 * Layzloading will create many files and slow on compiling, so best not to use lazyloading on devlopment.
 * The syntax is lazyloading, but we convert to proper require() with babel-plugin-syntax-dynamic-import
 * @see https://doc.laravue.dev/guide/advanced/lazy-loading.html
 */

Vue.use(Router);

/* Layout */
import Layout from '@/layout';

/* Router for modules */
import authRoutes from './modules/auth';
import dashboardRoutes from './modules/dashboard';
import myAccountRoutes from './modules/myAccount';
import adminToolsRoutes from './modules/adminTools';
import websiteToolsRoutes from './modules/websiteTools';

export const appRoutes = [
  ...dashboardRoutes,
  ...myAccountRoutes,
  ...adminToolsRoutes,
  ...websiteToolsRoutes
];

/* Constantly avilable routes (does not matter if a user is logged in or not) */
const constantRoutes = [
  ...authRoutes,
  {
    path: '',
    component: Layout,
    redirect: 'dashboard',
    hidden: true
  }
];

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
});

const router = createRouter();

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher; // reset router
  router.options.routes = [];
}

export default router;
