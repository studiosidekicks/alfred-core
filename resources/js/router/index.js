import Router from 'vue-router';
import AppShell from '../components/AppShell.vue';
import DashboardModule from '../modules/Dashboard';
import PagesModule from '../modules/Pages';

const routes = (vendorModules = []) => {
  return new Router({
    routes: [
      {
        path: '/',
        name: 'AppShell',
        component: AppShell,
        children: [
          ...DashboardModule,
          ...PagesModule,
          ...vendorModules
        ]
      }
    ]
  });
};

export default routes;