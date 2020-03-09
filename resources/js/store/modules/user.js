import { login, logout, getInfo } from '@/api/auth';
import { getIsUserLoggedIn, setIsUserLoggedIn } from '@/utils/auth';
import router, { resetRouter } from '@/router';
import store from '@/store';

const state = {
  isUserLoggedIn: getIsUserLoggedIn(),
  userInfo: null,
  roles: [],
  permissions: [],
};

const mutations = {
  SET_IS_USER_LOGGED_IN: (state, status) => {
    state.isUserLoggedIn = status;
  },
  SET_USER_INFO: (state, userInfo) => {
    state.userInfo = userInfo;
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles;
  },
  SET_PERMISSIONS: (state, permissions) => {
    state.permissions = permissions;
  },
};

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { email, password } = userInfo;
    return new Promise((resolve, reject) => {
      login({ email: email.trim(), password: password })
        .then(response => {
          commit('SET_IS_USER_LOGGED_IN', true);
          setIsUserLoggedIn(true);
          resolve('Logged in');
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo()
        .then(response => {
          const { data } = response;

          if (!data) {
            reject('Verification failed, please log in again.');
          }

          const { roles, permissions } = data;

          if (!roles || roles.length <= 0) {
            reject('getInfo: roles must be not empty array!');
          }

          commit('SET_USER_INFO', data);
          commit('SET_ROLES', roles);
          commit('SET_PERMISSIONS', permissions);
          resolve(data);
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user logout
  logout({ commit, state }) {
    return new Promise((resolve, reject) => {
      logout()
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          resolve();
        })
        .finally(() => {
          commit('SET_IS_USER_LOGGED_IN', false);
          commit('SET_ROLES', []);
          setIsUserLoggedIn(false);
          resetRouter();
        });
    });
  },

  // Dynamically modify permissions
  changeRoles({ commit, dispatch }, role) {
    return new Promise(async resolve => {
      // const { roles } = await dispatch('getInfo');

      const roles = [role.name];
      const permissions = role.permissions.map(permission => permission.name);
      commit('SET_ROLES', roles);
      commit('SET_PERMISSIONS', permissions);
      resetRouter();

      // generate accessible routes map based on roles
      const accessRoutes = await store.dispatch('permission/generateRoutes', { roles, permissions });

      // dynamically add accessible routes
      router.addRoutes(accessRoutes);

      resolve();
    });
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
