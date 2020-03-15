import { appRoutes } from '@/router';

/**
 * Check if it matches the current user right by meta.permissions
 * @param {String[]} permissions
 * @param route
 */
function canAccess(permissions, route) {
  if (route.meta) {
    let hasPermission = true;

    if (route.meta.permissions) {
      hasPermission = permissions.some(permission => route.meta.permissions.includes(permission));
    }

    return hasPermission;
  }

  // If no meta.permissions inputted - the route should be accessible
  return true;
}

/**
 * Find all routes with user's permissions
 * @param routes appRoutes
 * @param {String[]} permissions
 */
function filterAppRoutes(routes, permissions) {
  const res = [];

  routes.forEach(route => {
    const tmp = { ...route };
    if (canAccess(permissions, tmp)) {
      if (tmp.children) {
        tmp.children = filterAppRoutes(
          tmp.children,
          permissions
        );
      }
      res.push(tmp);
    }
  });

  return res;
}

const state = {
  routes: []
};

const mutations = {
  SET_ROUTES: (state, routes) => {
    state.routes = routes;
  },
};

const actions = {
  generateRoutes({ commit }, { permissions }) {
    return new Promise(resolve => {
      let accessedRoutes = filterAppRoutes(appRoutes, permissions);
      
      commit('SET_ROUTES', accessedRoutes);
      resolve(accessedRoutes);
    });
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
