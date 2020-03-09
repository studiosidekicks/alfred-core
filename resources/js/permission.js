import router from './router';
import store from './store';
import NProgress from 'nprogress'; // progress bar
import 'nprogress/nprogress.css'; // progress bar style
import { getIsUserLoggedIn } from '@/utils/auth'; // get token from cookie
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
    console.log({isUserLoggedIn});

    if (to.path === '/auth/login') {
      // if is logged in, redirect to the home page
      next({ path: '/' });
      NProgress.done();
    } else {
      // determine whether the user has obtained his permission roles through getInfo
      const hasRoles = store.getters.roles && store.getters.roles.length > 0;

      if (hasRoles) {
        console.log(23);
        next();
      } else {
        try {
          // get user info
          // note: roles must be a object array! such as: ['admin'] or ,['manager','editor']

          console.log('success!');

          const { roles, permissions } = await store.dispatch('user/getInfo');

          console.log({roles}, {permissions});

          // generate accessible routes map based on roles
          // const accessRoutes = await store.dispatch('permission/generateRoutes', roles, permissions);
          store.dispatch('permission/generateRoutes', { roles, permissions }).then(response => {
            // dynamically add accessible routes

            console.log(3424, response);
            
            router.addRoutes(response);

            // hack method to ensure that addRoutes is complete
            // set the replace: true, so the navigation will not leave a history record
            next({ ...to });
          });
        } catch (error) {
          console.log(234234, error);
          // remove token and go to login page to re-login
          await store.dispatch('user/logout');
          //Message.error(error || 'Has Error');
          next(`/auth/login?redirect=${to.path}`);
          NProgress.done();
        }
      }
    }
  } else {
    /* user is not logged in */

    console.log(23424, to.matched[0]);

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
