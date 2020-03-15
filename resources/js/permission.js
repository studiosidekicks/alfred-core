import router from './router';
import store from './store';
import NProgress from 'nprogress'; // progress bar
import 'nprogress/nprogress.css'; // progress bar style
import { getIsUserLoggedIn } from '@/utils/auth';
import getPageTitle from '@/utils/get-page-title';

NProgress.configure({ showSpinner: false }); // NProgress Configuration

// no redirect whitelist
const whiteList = [
  '/auth/login', 
  '/auth/forgot-password'
];

router.beforeEach(async(to, from, next) => {
  // start progress bar
  NProgress.start();
  // set page title
  document.title = getPageTitle(to.meta.title);

  // determine whether the user has logged in
  const isUserLoggedIn = getIsUserLoggedIn();

  if (isUserLoggedIn) {
    if (to.path === '/auth/login') {
      // if is logged in, redirect to the home page
      next({ path: '/' });
      NProgress.done();

    } else {
      // determine whether the user has obtained his permissions through getInfo
      const hasPermissions = store.getters.permissions && store.getters.permissions.length > 0;

      if (hasPermissions) {
        next();
        
      } else {
        try {
          const { permissions } = await store.dispatch('user/getInfo');

          // generate accessible routes map based on permissions
          store.dispatch('permission/generateRoutes', { permissions }).then(response => {
            router.addRoutes(response);
            next({ ...to });
          });

        } catch (error) {
          await store.dispatch('user/logout');
          next(`/auth/login?redirect=${to.path}`);
          NProgress.done();
        }
      }
    }
  } else {
    /* user is not logged in */

    if (whiteList.indexOf(to.matched[0] ? to.matched[0].path : '') !== -1) {
      // in the free login whitelist, go directly
      next();
    } else {
      // other pages that do not have permission to access are redirected to the login page.
      next(`/auth/login?redirect=${to.path}`);
      NProgress.done();
    }
  }
});

router.afterEach(() => {
  // finish progress bar
  NProgress.done();
});
